<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Glossary\Communication\Plugin;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Twig\Communication\Plugin\AbstractTwigExtensionPlugin;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @method \Spryker\Zed\Glossary\Business\GlossaryFacade getFacade()
 * @method \Spryker\Zed\Glossary\Communication\GlossaryCommunicationFactory getFactory()
 */
class TwigTranslatorPlugin extends AbstractTwigExtensionPlugin implements TranslatorInterface
{

    /**
     * @var \Generated\Shared\Transfer\LocaleTransfer
     */
    protected $localeTransfer;

    /**
     * @var string
     */
    protected $localeName;

    /**
     * @return string
     */
    public function getName()
    {
        return 'translator';
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('trans', [$this, 'trans']),
            new \Twig_SimpleFilter('transchoice', [$this, 'transchoice']),
        ];
    }

    /**
     * Specification:
     * - Translates the given message.
     *
     * @api
     *
     * @param string $id
     * @param array $parameters
     * @param string|null $domain
     * @param string|null $locale
     *
     * @return string
     */
    public function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        if ($locale !== null) {
            $this->setLocale($locale);
        }
        $localeTransfer = $this->getLocaleTransfer();

        if ($this->getFacade()->hasTranslation($id, $localeTransfer)) {
            $id = $this->getFacade()->translate($id, $parameters, $localeTransfer);
        }

        return $id;
    }

    /**
     * Specification:
     * - Translates the given choice message by choosing a translation according to a number.
     *
     * @api
     *
     * @param string $id
     * @param int $number
     * @param array $parameters
     * @param string|null $domain
     * @param string|null $locale
     *
     * @throws \InvalidArgumentException
     *
     * @return string The translated string
     */
    public function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null)
    {
        if ($locale !== null) {
            $this->setLocale($locale);
        }
        $localeTransfer = $this->getLocaleTransfer();

        $ids = explode('|', $id);

        if ($number === 1) {
            if (!$this->getFacade()->hasTranslation($ids[0], $localeTransfer)) {
                return $ids[0];
            }
            return $this->getFacade()->translate($ids[0], $parameters, $localeTransfer);
        }

        if (!isset($ids[1])) {
            throw new \InvalidArgumentException(sprintf('The message "%s" cannot be pluralized, because it is missing a plural (e.g. "There is one apple|There are %%count%% apples").', $id));
        }

        if (!$this->getFacade()->hasTranslation($ids[1], $localeTransfer)) {
            return $ids[1];
        }

        return $this->getFacade()->translate($ids[1], $parameters, $localeTransfer);
    }

    /**
     * @param string $localeName
     *
     * @return $this
     */
    public function setLocale($localeName)
    {
        $this->localeName = $localeName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->localeName;
    }

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return $this
     */
    public function setLocaleTransfer(LocaleTransfer $localeTransfer)
    {
        $this->localeTransfer = $localeTransfer;

        return $this;
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    protected function getLocaleTransfer()
    {
        if (!$this->localeTransfer) {
            if ($this->getLocale() === null) {
                throw new \InvalidArgumentException('No locale or localeTransfer specified. You need to set a localeName or a LocaleTransfer, otherwise translation can not properly work.');
            }
            $localeTransfer = new LocaleTransfer();
            $localeTransfer->setLocaleName($this->localeName);

            $this->localeTransfer = $localeTransfer;
        }

        return $this->localeTransfer;
    }

}
