<?php echo $header; ?>

<?php echo $column_left; ?>


<div id="content" class="departamento">
    <?php if ($welcome) { ?>

    <div class="middle">
        <h1><?php echo $heading_title; ?></h1>
        <div><?php echo $welcome; ?></div>
    </div>
    <?php } ?>


    <?php foreach ($modules as $module) { ?>
    <?php echo ${$module['code']}; ?>
    <?php } ?>
</div>

<div class="content">


<div class="menu-bar">
    <div class="aligner"><ul>
        <li><a href="#">Menu Item</a></li>
        <li><a href="#">Menu Item</a></li>
        <li><a href="#">Menu Item</a></li>
        <li><a href="#">Menu Item</a></li>
        <li><a href="#">Menu Item</a></li></div>
    </ul>
</div>



<div class="featured-banners">

    <div class="controls">
        <div class="prev"></div>
        <div class="next"></div>
    </div>

    <div class="holder">

        <div class="banner">
            <div class="info">
                <em>Pol�tica</em>
                <h5>Aenean lacinia bibendum nulla sed consectetur.</h5>
            </div>
            <img src="static/images/banners/featured1.jpg"/>
        </div>

        <div class="banner">
            <div class="info">
                <em>Corrup��o</em>
                <h5>Inceptos Dolor Cras Cursus Sit</h5>
            </div>
            <img src="static/images/banners/featured2.jpg"/>
        </div>

        <div class="banner">
            <div class="info">
                <em>Pol�tica</em>
                <h5>Nullam id dolor id nibh ultricies vehicula ut id elit.</h5>
            </div>
            <img src="static/images/banners/featured3.jpg"/>
        </div>

    </div>
</div>


<div class="featured-info">
    <h3>Destaques</h3>

    <dl>
        <dd><a href="#">Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</a></dd>
        <dt>por <strong><a href="#">Andr� Silveira</a></strong>     em 18/04/12</dt>
        <dd><a href="#">Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</a></dd>
        <dt>por <strong><a href="#">Andr� Silveira</a></strong>     em 18/04/12</dt>
        <dd><a href="#">Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</a></dd>
        <dt>por <strong><a href="#">Andr� Silveira</a></strong>     em 18/04/12</dt>
    </dl>

</div>



<div class="trending">

    <h1>Em assunto</h1>

    <div class="subject">

        <span>Selecione a categoria</span>

        <ul>
            <li><a href="#">Nome Categoria</a></li>
            <li><a href="#">Nome Categoria</a></li>
            <li><a href="#">Nome Categoria</a></li>
            <li><a href="#">Nome Categoria</a></li>
            <li><a href="#">Nome Categoria</a></li>
        </ul>
    </div>


    <div class="content grid three">

        <div class="item article">
            <div class="photo">
                <a href="#"><img src="static/images/banners/trending1.jpg"/></a>
            </div>
            <em><a href="#">Pol�tica</a></em>
            <h3><a href="#">Tortor Sollicitudin Commodo Consectetur Cursus</a></h3>
            <span><a href="#">Nullam id dolor id nibh ultricies vehicula ut id elit. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</a></span>

            <div class="badges">
                <div class="likes">307</div>
                <div class="favs">29</div>
            </div>
        </div>

        <div class="item video">
            <div class="photo">
                <div class="play"></div>
                <a href="#"><img src="static/images/banners/trending1.jpg"/></a>
            </div>
            <em><a href="#">Pol�tica</a></em>
            <h3><a href="#">Tortor Sollicitudin Commodo Consectetur Cursus</a></h3>
            <div class="badges">
                <div class="likes">307</div>
                <div class="favs">29</div>
            </div>
        </div>

        <div class="item article">
            <div class="photo">
                <a href="#"><img src="static/images/banners/trending1.jpg"/></a>
            </div>
            <em><a href="#">Pol�tica</a></em>
            <h3><a href="#">Tortor Sollicitudin Commodo Consectetur Cursus</a></h3>
            <span><a href="#">Nullam id dolor id nibh ultricies vehicula ut id elit. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</a></span>

            <div class="badges">
                <div class="likes">307</div>
                <div class="favs">29</div>
            </div>
        </div>

        <div class="item video">
            <div class="photo">
                <div class="play"></div>
                <a href="#"><img src="static/images/banners/trending1.jpg"/></a>
            </div>
            <em><a href="#">Pol�tica</a></em>
            <h3><a href="#">Tortor Sollicitudin Commodo Consectetur Cursus</a></h3>
            <div class="badges">
                <div class="likes">307</div>
                <div class="favs">29</div>
            </div>
        </div>

        <div class="item article">
            <div class="photo">
                <a href="#"><img src="static/images/banners/trending1.jpg"/></a>
            </div>
            <em><a href="#">Pol�tica</a></em>
            <h3><a href="#">Tortor Sollicitudin Commodo Consectetur Cursus</a></h3>
            <span><a href="#">Nullam id dolor id nibh ultricies vehicula ut id elit. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</a></span>

            <div class="badges">
                <div class="likes">307</div>
                <div class="favs">29</div>
            </div>
        </div>

        <div class="item video">
            <div class="photo">
                <div class="play"></div>
                <a href="#"><img src="static/images/banners/trending1.jpg"/></a>
            </div>
            <em><a href="#">Pol�tica</a></em>
            <h3><a href="#">Tortor Sollicitudin Commodo Consectetur Cursus</a></h3>
            <div class="badges">
                <div class="likes">307</div>
                <div class="favs">29</div>
            </div>
        </div>

        <div class="item article">
            <div class="photo">
                <a href="#"><img src="static/images/banners/trending1.jpg"/></a>
            </div>
            <em><a href="#">Pol�tica</a></em>
            <h3><a href="#">Tortor Sollicitudin Commodo Consectetur Cursus</a></h3>
            <span><a href="#">Nullam id dolor id nibh ultricies vehicula ut id elit. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</a></span>

            <div class="badges">
                <div class="likes">307</div>
                <div class="favs">29</div>
            </div>
        </div>

        <div class="item video">
            <div class="photo">
                <div class="play"></div>
                <a href="#"><img src="static/images/banners/trending1.jpg"/></a>
            </div>
            <em><a href="#">Pol�tica</a></em>
            <h3><a href="#">Tortor Sollicitudin Commodo Consectetur Cursus</a></h3>
            <div class="badges">
                <div class="likes">307</div>
                <div class="favs">29</div>
            </div>
        </div>


    </div>

</div>


</div>

</div>

<?php echo $column_right; ?>

<?php echo $footer; ?>
