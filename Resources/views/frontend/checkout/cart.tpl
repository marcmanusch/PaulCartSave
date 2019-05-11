{extends file='parent:frontend/checkout/cart.tpl'}

{block name='frontend_checkout_actions_link_last'}

    {if isset($smarty.session.Shopware.paulSaveCartHash)}
        <div class="alert is--success is--rounded">
            <div class="alert--icon">
                <!-- Alert message icon -->
                <i class="icon--element icon--disk"></i>
            </div>
            <div class="alert--content">
                {s name="CheckoutActionsLinkSaveCartMessage" namespace="frontend/checkout/actions"}Ihr Warenkorb wurde erfolgreich gespeichert:{/s}
                <a href="./PaulCartSave/loadArticles?hash={$smarty.session.Shopware.paulSaveCartHash}">Link</a>
            </div>
        </div>
    {/if}


    {if $active_cart_save}
        <form method="post" action="{url controller='PaulCartSave' action='saveCart'}"
              class="save-cart form" data-eventname="submit" data-showmodal="false">

            {foreach $sBasket.content as $article}
                <input type="hidden"
                       name="cartSaveProducts[]"
                       value="{$article.ordernumber}">
            {/foreach}


            <button class="btn is--primary is--icon-right is--center is--large"
                    name="{s name="CheckoutActionsLinkSaveCart" namespace="frontend/checkout/actions"}Warenkorb speichern{/s}">
                {s name="CheckoutActionsLinkSaveCart" namespace="frontend/checkout/actions"}Warenkorb speichern{/s}
            </button>

        </form>
    {/if}
    {$smarty.block.parent}
{/block}
