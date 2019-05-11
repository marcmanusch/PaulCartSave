{extends file='parent:frontend/checkout/cart.tpl'}

{block name='frontend_checkout_actions_link_last'}

    {if isset($smarty.session.Shopware.paulSaveCartHash)}
        <div class="alert is--success is--rounded">
            <div class="alert--icon">
                <!-- Alert message icon -->
                <i class="icon--element icon--disk"></i>
            </div>

            <div class="alert--content save-cart">
                {s name="CheckoutActionsLinkSaveCartMessage" namespace="frontend/checkout/actions"}Ihr Warenkorb wurde erfolgreich gespeichert:{/s}

                <!-- Copy -->
                <span class="hide--on--mobile">
                    <input class="btn" type="text" value="{$Shop->getHost()}{$Shop->getbasePath()}/PaulCartSave/loadArticles?hash={$smarty.session.Shopware.paulSaveCartHash}" id="saveCartLink">
                    <button  onclick="clipBoard()">{s name="CheckoutActionsLinkSaveCartClip" namespace="frontend/checkout/actions"}Link kopieren{/s}</button>
                </span>

                <div id="share">

                    <a class="email" href="mailto:?subject=PaulGurkes Warenkorb&amp;body={$Shop->getHost()}{$Shop->getbasePath()}/PaulCartSave/loadArticles?hash={$smarty.session.Shopware.paulSaveCartHash}" target="_self" target="blank">
                        <i class="icon--mail" aria-hidden="true"></i>
                        E-mail
                    </a>

                    <a class="whatsapp hide--on--desktop" href="whatsapp://send?text=Hey! Hier findest du meinen Warenkorb bei PaulGurkes: {$Shop->getHost()}{$Shop->getbasePath()}/PaulCartSave/loadArticles?hash={$smarty.session.Shopware.paulSaveCartHash}" target="_blank"" target="blank">
                    <i class="icon--share" aria-hidden="true"></i>
                        Whatsapp
                    </a>

                </div>

            </div>
        </div>
    {/if}


    {if $active_cart_save}
        <form method="post" action="{url controller='PaulCartSave' action='saveCart'}"
              class="save-cart form" data-eventname="submit" data-showmodal="false">

            {assign var=products value=[]}
            {assign var=counter value=0}


            {foreach $sBasket.content as $article}

                <input type="hidden"
                       name="cartSaveProducts[]"
                       value="{$article.ordernumber}">
                <input type="hidden"
                       name="cartSaveProductsQty[]"
                       value="{$article.quantity}">
            {/foreach}

            <button class="btn is--primary is--center is--large"
                    name="{s name="CheckoutActionsLinkSaveCart" namespace="frontend/checkout/actions"}Warenkorb speichern{/s}">
                {s name="CheckoutActionsLinkSaveCart" namespace="frontend/checkout/actions"}Warenkorb speichern{/s}
            </button>

        </form>
    {/if}
    {$smarty.block.parent}
{/block}
