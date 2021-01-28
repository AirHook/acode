<!-- BEGIN PAGE CONTENT BODY -->
<div class="note note-default" style="padding-left:0px;padding-right:0px;border-left:none;">
    <?php if ($got_user_token)
    { ?>

        <h4> Dear Admin </h4>
        <br />
        <p> Congratulations! Successfully granted access to eBay items via user token. </p>
        <p> You may now continue working on eBay items or products that are posted to eBay. </p>

        <?php
    }
    else
    { ?>

        <h4> Dear Admin </h4>
        <br />
        <p> If you have landed on this page, it's either the user access token for eBay items is already expired, or, that you may have had some wrong credentials used in logging in to eBay. </p>
        <br />
        <p> In order to be able to use API for eBay properly, a valid access token is required. You can get access token by properly logging in to your eBay account via the button below. After logging in to eBay, you will be asked to "<strong>AGREE</strong>" to grant permission for <?php echo $this->webspace_details->name; ?> to access data from your eBay account. </p>
        <br />
        <p> You will be returned to this page after logging in to eBay. </p>
        <br />
        <p> Login to eBay:
            <a class="btn dark btn-sm btn-outline" href="https://auth.ebay.com/oauth2/authorize?client_id=ReySteph-InstyleN-PRD-1f785c25d-adfce627&response_type=code&redirect_uri=Rey_Stephen_Mil-ReySteph-Instyl-wqvqxmhd&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly" target="">Sign In To eBay</a>
        </p>

        <?php
    } ?>
</div>
<!-- END PAGE CONTENT BODY -->
