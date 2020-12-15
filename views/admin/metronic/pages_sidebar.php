<style>
.pages.active {
    background-color: #f2f6f9;
}
</style>
<ul class="list-unstyled nested-nav">

    <li>
        Edit Pages
    </li>
    <hr style="margin:8px 0;" />

    <?php
    if (@$designers)
    {
        foreach ($designers as $designer)
        {
            $des_webspace_options = json_decode($designer->webspace_options, TRUE);
            ?>

        <br />
        <li>
            <strong> <?php echo $designer->designer; ?> </strong>
        </li>
        <hr style="margin:8px 0;" />
        <li>
            General Pages
        </li>

        <?php if (@$des_webspace_options['wholesale_only_site'] != '1') { ?>

        <li class="pages <?php echo strpos($this->uri->uri_string(), 'ordering/cs/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/ordering/cs/'.$designer->webspace_id); ?>" class="dcn">
                Ordering
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'shipping/cs/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/shipping/cs/'.$designer->webspace_id); ?>" class="dcn">
                Shipping
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'return_policy/cs/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/return_policy/cs/'.$designer->webspace_id); ?>" class="dcn">
                Return Policy
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'privacy_notice/cs/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/privacy_notice/cs/'.$designer->webspace_id); ?>" class="dcn">
                Privacy Notice
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'faq/cs/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/faq/cs/'.$designer->webspace_id); ?>" class="dcn">
                FAQ
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'terms_of_use/cs/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/terms_of_use/cs/'.$designer->webspace_id); ?>" class="dcn">
                Terms Of Use
            </a>
        </li>
        <br />
        <li>
            Wholesale User Pages
        </li>

        <?php } ?>

        <li class="pages <?php echo strpos($this->uri->uri_string(), 'ordering/ws/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/ordering/ws/'.$designer->webspace_id); ?>" class="dcn">
                Ordering
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'shipping/ws/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/shipping/ws/'.$designer->webspace_id); ?>" class="dcn">
                Shipping
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'return_policy/ws/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/return_policy/ws/'.$designer->webspace_id); ?>" class="dcn">
                Return Policy
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'privacy_notice/ws/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/privacy_notice/ws/'.$designer->webspace_id); ?>" class="dcn">
                Privacy Notice
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'faq/ws/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/faq/ws/'.$designer->webspace_id); ?>" class="dcn">
                FAQ
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'terms_of_use/ws/'.$designer->webspace_id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/terms_of_use/ws/'.$designer->webspace_id); ?>" class="dcn">
                Terms Of Use
            </a>
        </li>

            <?php
        }
    }
    else
    { ?>

        <li>
            General Pages
        </li>

        <?php if ( ! @$this->webspace_details->options['wholesale_only_site']) { ?>

        <li class="pages <?php echo strpos($this->uri->uri_string(), 'ordering/cs/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/ordering/cs/'.$this->webspace_details->id); ?>" class="dcn">
                Ordering
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'shipping/cs/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/shipping/cs/'.$this->webspace_details->id); ?>" class="dcn">
                Shipping
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'return_policy/cs/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/return_policy/cs/'.$this->webspace_details->id); ?>" class="dcn">
                Return Policy
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'privacy_notice/cs/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/privacy_notice/cs/'.$this->webspace_details->id); ?>" class="dcn">
                Privacy Notice
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'faq/cs/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/faq/cs/'.$this->webspace_details->id); ?>" class="dcn">
                FAQ
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'terms_of_use/cs/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/terms_of_use/cs/'.$this->webspace_details->id); ?>" class="dcn">
                Terms Of Use
            </a>
        </li>
        <br />
        <li>
            Wholesale User Pages
        </li>

        <?php } ?>

        <li class="pages <?php echo strpos($this->uri->uri_string(), 'ordering/ws/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/ordering/ws/'.$this->webspace_details->id); ?>" class="dcn">
                Ordering
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'shipping/ws/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/shipping/ws/'.$this->webspace_details->id); ?>" class="dcn">
                Shipping
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'return_policy/ws/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/return_policy/ws/'.$this->webspace_details->id); ?>" class="dcn">
                Return Policy
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'privacy_notice/ws/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/privacy_notice/ws/'.$this->webspace_details->id); ?>" class="dcn">
                Privacy Notice
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'faq/ws/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/faq/ws/'.$this->webspace_details->id); ?>" class="dcn">
                FAQ
            </a>
        </li>
        <li class="pages <?php echo strpos($this->uri->uri_string(), 'terms_of_use/ws/'.$this->webspace_details->id) !== FALSE ? 'active' : ''; ?>">
            <a href="<?php echo site_url('admin/pages/edit/index/terms_of_use/ws/'.$this->webspace_details->id); ?>" class="dcn">
                Terms Of Use
            </a>
        </li>

        <?php
    }
    ?>

</ul>
