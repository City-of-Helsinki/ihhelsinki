<html>
<body id="mimemail-body">
<div id="center">
    <div id="main">
        <style>
            #header,
            #content,
            #footer {
                max-width: 960px;
                font-size: 14px;
                font-family: Arial, sans-serif;
            }

            #content h2 {
                margin: .5cm 0 .2cm 0;
            }

            #content .questions .item {
                margin: 0 0 .4cm 0;
            }

            #content .question {
                margin-bottom: .1cm;
            }

            #content .answers h3 {
                border-bottom: 1px solid #111;
            }

            #footer {
                display: block;
                margin: 2cm 0 0 0;
                padding: 1.5cm 1.5cm 0 1.5cm;
                background: #f2f0f2;
            }

            #footer .column {
                float: left;
                display: block;
            }

            #footer .column .content {
                height: 3cm;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
            }

            #footer .column.first {
                width: 33%;
            }

            #footer .column.first .content {
                padding-right: 1cm;
            }

            #footer .column.second {
                width: 66%;
            }

            #footer .column.second .content {
                padding-left: 1cm;
            }

            #footer .copy {
                clear: both;
                color: #dad8da;
                border-top: 1px solid;
                padding: .1cm 0 .5cm 0;
                margin: 2cm 0;
            }

            #footer .copy p {
                margin: 0;
                font-size: 0.8em;
            }
        </style>

<!--        <div id="header">-->
<!--            <h1>--><?php //the_field( 'email_title', 'option' ); ?><!--</h1>-->
<!--        </div>-->

        <div id="content">
            <div>
<!--                <h2>Your welcome guide</h2>-->
                <div class="views-element-container">
                    <div class="answers view view-arrival-app view-id-arrival_app view-display-id-answer_html">
                        <div class="view-content">
                            <?php echo $email_content; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="column first">
                <div class="content">
                    <img src="<?php the_field( 'email_logo', 'option' ); ?>" width="160" height="auto" alt="IHH Logo"/>
                </div>
            </div>
            <div class="column second">
                <div class="content">
                    <?php the_field( 'email_footer', 'option' ); ?>
                </div>
            </div>
            <div class="copy">
                <p>&copy; International House Helsinki</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
