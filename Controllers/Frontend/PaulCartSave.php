<?php

use Shopware\Components\CSRFWhitelistAware;
use Shopware\Bundle\AttributeBundle\Service\DataLoader as AttributeDataLoader;
use Shopware\Bundle\AttributeBundle\Service\DataPersister as AttributeDataPersister;
/**
 * Frontend controller
 */
class Shopware_Controllers_Frontend_PaulCartSave extends Enlight_Controller_Action implements CSRFWhitelistAware
{
    /**
     * @return array
     */
    public function getWhitelistedCSRFActions()
    {
        return [
            'loadArticles',
            'saveCart'
        ];
    }

    public function saveCartAction()
    {
        # no template
        Shopware()->Plugins()->Controller()->ViewRenderer()->setNoRender();

        # get articles from "save Button"
        $cartSaveProducts = $this->Request()->getParam('cartSaveProducts');
        $cartSaveProductsQty = $this->Request()->getParam('cartSaveProductsQty');

        $hash = bin2hex(random_bytes(16));
        $now = date('Y-m-d H:i:s');

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->container->get('dbal_connection');
        $builder = $connection->createQueryBuilder();
        $builder->insert('s_plugin_save_cart')
            ->values(
                array(
                    'hash' => '?',
                    'articles'   => '?',
                    'date'    => '?',
                    'quantity' => '?'
                )
            )
            ->setParameter(0, $hash)
            ->setParameter(1, JSON_encode($cartSaveProducts))
            ->setParameter(2, $now)
            ->setParameter(3, JSON_encode($cartSaveProductsQty));
        $builder->execute();

        // Add hash to session
        $session = $this->container->get('session');
        $view = $this->View();
        $view->assign('paulSaveCartHash', $hash);

        $session->paulSaveCartHash = $hash;

        // Zum Warenkorb weiterleiten, nachdem alle Artikel im Warenkorb sind
        $this->redirect(array(
            'module'     => "frontend",
            'controller' => "checkout",
            'action'     => "cart"
        ));
    }


    public function loadArticlesAction()
    {
        # no template
        Shopware()->Plugins()->Controller()->ViewRenderer()->setNoRender();

        // Get Config

        $config = $this->container->get('shopware.plugin.config_reader')->getByPluginName('PaulCartSave');
        $use_voucher = $config['use_voucher'];

        $hash = $this->Request()->getParam('hash');
        $saveCartArray = $this->getArticles($hash);
        $saveCartArray = $saveCartArray[0];

        $articleArray = JSON_decode($saveCartArray['articles']);
        $qtyArray = JSON_decode($saveCartArray['quantity']);

        // clear session
        $session = $this->container->get('session');
        $session->paulSaveCartHash = NULL;

        //Lösche Warenkorb
        Shopware()->Modules()->Basket()->clearBasket();

        //Füge jeden Artikel dem Warenkorb hinzu
        foreach ($articleArray as $key => $article) {

            try {

                // Hole den Warenkorb
                $basketId = Shopware()->Modules()->Basket()->sAddArticle($article, $qtyArray[$key]);

                if($use_voucher) {
                    // versuche Gutschein zu speichern
                    $basketId = Shopware()->Modules()->Basket()->sAddVoucher($article);
                }


                /* @var $attributeDataLoader AttributeDataLoader */
                $attributeDataLoader = $this->get( "shopware_attribute.data_loader" );

                /* @var $attributeDataPersister AttributeDataPersister */
                $attributeDataPersister = $this->get( "shopware_attribute.data_persister" );

                // Speichere die Artikel in den Warenkorb
                $attributes = $attributeDataLoader->load( "s_order_basket_attributes", $basketId );
                $attributeDataPersister->persist( $attributes, "s_order_basket_attributes", $basketId );

            } catch (Exception $e) {}

        }

        // Zum Warenkorb weiterleiten, nachdem alle Artikel im Warenkorb sind
        $this->redirect(array(
            'module'     => "frontend",
            'controller' => "checkout",
            'action'     => "cart"
        ));
    }

    public function getArticles($hash) {

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->container->get('dbal_connection');
        $builder = $connection->createQueryBuilder();
        $builder->select('*')
            ->from('s_plugin_save_cart', 'spsc')
            ->where('spsc.hash = \'' . $hash . '\'');

        $builder->execute();
        $stmt = $builder->execute();
        return $stmt->fetchAll();
    }
}
