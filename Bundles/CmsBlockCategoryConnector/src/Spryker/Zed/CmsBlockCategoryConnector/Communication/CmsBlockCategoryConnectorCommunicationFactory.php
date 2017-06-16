<?php

namespace Spryker\Zed\CmsBlockCategoryConnector\Communication;


use Spryker\Zed\CmsBlockCategoryConnector\Communication\DataProvider\CmsBlockCategoryDataProvider;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\Form\CmsBlockCategoryType;
use Spryker\Zed\CmsBlockCategoryConnector\CmsBlockCategoryConnectorDependencyProvider;
use Spryker\Zed\CmsBlockCategoryConnector\Dependency\Facade\LocaleFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CmsBlockCategoryConnectorCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @var string
     */
    protected $currentLocale;

    /**
     * @return CmsBlockCategoryDataProvider
     */
    public function createCmsBlockCategoryDataProvider()
    {
        return new CmsBlockCategoryDataProvider(
            $this->getCategoryQueryContainer(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return CmsBlockCategoryType
     */
    public function createCmsBlockCategoryType()
    {
        return new CmsBlockCategoryType();
    }

    public function createCmsBlockCategoryFormBuilder()
    {
        $form = $this->createCmsBlockCategoryType();
        $dataProvider = $this->createCmsBlockCategoryDataProvider();

        return $this->getFormFactory()
            ->createBuilder(
                $form,
                $dataProvider->getData(),
                $dataProvider->getOptions()
            );
    }

    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    protected function getCurrentLocale()
    {
        if ($this->currentLocale === null) {
            $this->currentLocale = $this->getLocaleFacade()
                ->getCurrentLocale();
        }

        return $this->currentLocale;
    }

    /**
     * @return LocaleFacadeInterface
     */
    protected function getLocaleFacade()
    {
        return $this->getProvidedDependency(CmsBlockCategoryConnectorDependencyProvider::FACADE_LOCALE);
    }

    protected function getCategoryQueryContainer()
    {
        return $this->getProvidedDependency(CmsBlockCategoryConnectorDependencyProvider::QUERY_CONTAINER_CATEGORY);
    }

}