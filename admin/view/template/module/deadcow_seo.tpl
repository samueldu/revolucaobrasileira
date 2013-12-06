<?php echo $header; ?>
<?php if (isset($error_warning)) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if (isset($success)) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<style type="text/css">
    .form .button {
        margin-top:6px;
    }
    .button button {
        background: url("view/image/button_right.png") no-repeat scroll right top transparent;
        color: #FFFFFF;
        display: block;
        padding: 3px 10px 5px 2px;
        border: none;
        cursor: pointer;
    }
    .template-info {
        font-size:10px;
        color:#999;
        font-style:italic;
    }
</style>
<div class="box">
    <div class="left"></div>
    <div class="right"></div>
    <div class="heading">
        <h1 style="background-image: url('view/image/module.png');"><?php echo $heading_title; ?></h1>

        <div class="buttons"><a onclick="location = '<?php echo $cancel; ?>';"
                                class="button"><span><?php echo $back; ?></span></a></div>
    </div>
    <div class="content">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <table class="form">
                <tr>
                    <td><?php echo $categories;?></td>
                    <td>
                        <label for="categories_template"><?php echo $template;?> </label><input type="text" id="categories_template" name="categories_template" value="<?php echo $categories_template;?>" size="80">
                        <div class="template-info"><?php echo $available_category_tags;?></div>
                        <div class="button"><button type="submit" name="categories" value="categories"><?php echo $generate;?></button></div><br/>
                        <?php echo $warning_clear;?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $products;?></td>
                    <td>
                        <label for="products_template"><?php echo $template;?> </label><input type="text" id="products_template" name="products_template" value="<?php echo $products_template;?>" size="80"><br/>
                        <div class="template-info"><?php echo $available_product_tags;?></div>
                        <div class="button"><button type="submit" name="products" value="products"><?php echo $generate;?></button></div><br/>
                        <?php echo $warning_clear;?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $manufacturers;?></td>
                    <td>
                        <label for="manufacturers_template"><?php echo $template;?> </label><input type="text" id="manufacturers_template" name="manufacturers_template" value="<?php echo $manufacturers_template;?>" size="80"><br/>
                        <div class="template-info"><?php echo $available_manufacturer_tags;?></div>
                        <div class="button"><button type="submit" name="manufacturers" value="manufacturers"><?php echo $generate;?></button></div><br/>
                        <?php echo $warning_clear;?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $products." ".$meta_keywords;?></td>
                    <td>
                        <label for="meta_template">META-KEYWORDS</label><input type="text" id="meta_template" name="meta_template" value="<?php echo $meta_template;?>" size="80"><br/>
                        <div class="template-info"><?php echo $available_meta_tags;?></div><br/>
                        <label for="meta_template">META-DESCRIPTION </label>
                        <input type="text" id="meta_template_description" name="meta_template_description" value="<?php echo $meta_template_description;?>" size="80"><br/>
                        <div class="template-info"><?php echo $available_meta_tags;?></div><br/>
                        <!--
                        <?php if (in_array('curl', get_loaded_extensions())) {?>
                        <input type="checkbox" name="yahoo_checkbox"<?php if ($yahoo_checkbox==1) echo 'checked="checked"';?>><?php echo $add_from_yahoo;?><br/>
                        <label for="yahoo_id"><?php echo $your_yahoo_id;?> </label><input type="text" id="yahoo_id" name="yahoo_id" value="<?php echo $yahoo_id;?>" size="80"><br/>
                        <div class="template-info"><?php echo $get_yahoo_id;?></div><br/>
                        <?php } else {?>
                        <div><?php echo $curl_not_enabled;?></div>
                        <input type="hidden" id="yahoo_id" name="yahoo_id" value="">
                        <?php } ?>
                        -->
                                                <input type="hidden" id="yahoo_id" name="yahoo_id" value="">    
                        <div class="button"><button type="submit" name="meta_keywords" value="meta_keywords"><?php echo $generate;?></button></div><br/>
                        <?php echo $warning_clear;?>
                    </td>
                </tr>
                 <tr>
                    <td><?php echo $categories." ".$meta_keywords;?></td>
                    <td>
                        <label for="meta_template">META-KEYWORDS</label><input type="text" id="meta_template_cat" name="meta_template_cat" value="<?php echo $meta_template_cat;?>" size="80"><br/>
                        <div class="template-info"><?php echo $available_meta_tags;?></div><br/>
                        <label for="meta_template">META-DESCRIPTION </label>
                        <input type="text" id="meta_template_cat_description" name="meta_template_cat_description" value="<?php echo $meta_template_cat_description;?>" size="80"><br/>
                        <div class="template-info"><?php echo $available_meta_tags;?></div><br/>
                        <div class="button"><button type="submit" name="meta_keywords_cat" value="meta_keywords_cat"><?php echo $generate;?></button></div><br/>
                        <?php echo $warning_clear;?>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php echo $footer; ?>