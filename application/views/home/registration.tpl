{extends file='base_layout.tpl'}
{block name=head}
    {css}
    {js position='head'}
    <style>

    </style>
{/block}
{block name=body}
    <div class="container">

        <!-- Header -->
        <div id="header">
            <div id="nav">
                <nav class="navbar" role="navigation">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse-nav">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">
                                {picture path='/responsive/size' alt=$title title=$title src='home/logo.png'}
                            </a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li id="language-select-box" class="dropdown language-select-box">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        {lang}Language{/lang}
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="language-select-box">
                                        <li>
                                            <form name="setLangChinese" action="{site_url url='welcome/switch_lang'}" method="POST">
                                                <input type="hidden" name="language" value="chinese" />
                                                <input class="btn btn-link" type="submit" value="中文">
                                            </form>
                                        </li>

                                        <li>
                                            <form name="setLangEnglish" action="{site_url url='welcome/switch_lang'}" method="POST">
                                                <input type="hidden" name="language" value="english" />
                                                <input class="btn btn-link" type="submit" value="ENGLISH">
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div><!-- /.navbar-collapse -->

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse navbar-collapse-nav">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
            </div><!-- /.nav -->

        </div>

        <!-- send mail -->

        <div class="center-row" id="send_mail">
            <ul class="nav navbar-nav nav-head">
                <li>
                    <div class="response_row messagesbar">
                        {alert}
                    </div>
                </li>
            </ul>
            <ul class="nav navbar-nav nav-body">
                <li>
                    {form class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='ibox/register'}" method="POST"}
                        <div class="panel panel-default">
                            <div class="panel-heading">{lang}Registration Page {/lang}</div>
                            <div class="panel-body">

                                <div class="registration-form">
                                    <div class="info"> {lang}Pinet WIFI Box Information{/lang}</div>
                                    {field_group field='name'  layout=false}
                                    {label}
                                        <p class="help-block">Please name your Pinet WiFi Box This is for your reference only</p>
                                    {input}
                                    {/field_group}

                                    {field_group field='hostname' layout=false}
                                    {label}
                                        <p class="help-block">This is the hostname of your box, can't be changed </p>
                                    {input}
                                    {/field_group}

                                    {field_group field='manual' layout=false}
                                    {label}
                                    {/field_group}

                                    {field_group layout=false field='address'}
                                    {input}
                                    {/field_group}
                                    <div class="row">
                                        {field_group  layout=false field='city' class='col-1280-6'}
                                        {input}
                                        {/field_group}

                                        {field_group  layout=false field='country' class='col-1280-6'} {input}{/field_group}
                                    </div>
                                    <div class="row">
                                        {field_group  layout=false field='state' class='col-1280-6'} {input}{/field_group}
                                        {field_group  field='zip_code' layout=false class='col-1280-6'} {input}{/field_group}
                                    </div>
                                    {field_group field='notes' layout=false}
                                    {label}
                                    {textarea}
                                    {/field_group}

                                    {input field='longitude' type='hidden'}
                                    {input field='latitude' type='hidden'}
                                    {input field='serial' type='hidden' value='123'}
                                </div>
                                <div class="registration-map">
                                    <div class="info"> {lang} Location<br>
                                            Please pinpoint the location of your business using
                                            Maps and manually enter the full address {/lang}</div>
                                    <div class="row">
                                        {field_group class='col-1280-11' field='search' layout=false}
                                        {input}
                                        {/field_group}
                                        <div class='search'><i class="glyphicon glyphicon-search"></i></div>
                                    </div>
                                    <div class="bmap-container" id="place_container">
                                        <iframe src="{site_url url='/page/home/map'}" width="100%"></iframe>
                                    </div>
                                </div>
                            </div>
                            <input class="btn pinet-btn-blue" type="submit" value="{lang}Submit{/lang}">
                        </div>
                    {/form}

                </li>
            </ul>
        </div>

        <!-- footer -->
        <div id="contact_us" class="res_row">
            <ul class="nav navbar-nav nav-text">
                <li>
                    <p>{lang}FIND US{/lang}</p>
                </li>
            </ul>
            <ul id="nav-address" class="nav navbar-nav nav-content">
                <li>
                    <p class="info">Suzhou Pyle Network Technology Co., Ltd. Suzhou City, Jiangsu Province Star Lake Street, 328 Industrial Park 15 506 Creative Industry Park</p>
                </li>
                <li>
                    <p class="info">Suzhou Pyle Network Technology Co., Ltd. Anhui Branch Luyang District, Hefei, Anhui Changjiang Road, Renhe Building 1106</p>
                </li>
                <li>
                    <p class="info">Suzhou Pyle Network Technology Co., Ltd. Hubei Branch Hongshan District, Wuhan City, Hubei Province Guangbutun Central China Digital City 7018</p>
                </li>
            </ul>
            <ul  id="copyright" class="nav navbar-nav nav-text">
                <li>
                    <p class="logo">{picture path='/responsive/size' alt=$title title=$title src='home/logo_grey.png'}</p>
                    <p class="info">©COPY RIGHT PINET,INC TERMS,PRIVACY,CONTACT</p>
                    <p class="email"><a target="_top" href="mailto:info@pinet.co">info@pinet.co</a></p>
                </li>
            </ul>
            <ul id="sns-link" class="nav navbar-nav nav-content">
                <li>
                    <p>{picture path='/responsive/size' alt=$title title=$title src='home/wechat_login_icon.png'}</p>
                </li>
                <li>
                    <p>{picture path='/responsive/size' alt=$title title=$title src='home/weibo_login_icon.png'}</p>
                </li>
                <li>
                    <p>{picture path='/responsive/size' alt=$title title=$title src='home/qq_login_icon.png'}</p>
                </li>
            </ul>
        </div>

    </div>
{/block}
{block name=foot}
    {js}
    <script type="text/javascript">
        var map;
        $(function(){
            $('.search').on('click', function(){
                console.log($('#field_search').val());
                $('#place_container').find('iframe').get(0).contentWindow.localSearch.search($('#field_search').val());
            });
            if($.isFunction($.fn.jqBootstrapValidation)) {
                $("input,select,textarea").not("[type=image],[type=submit],[type=file]").jqBootstrapValidation();
            }

            $("input,select,textarea").not("[type=image],[type=submit],[type=file]").on('validation.validation.warning.many', function(e, helpBlock){
                if(helpBlock && $.isFunction(helpBlock.find)) {
                    helpBlock.find('ul li').addClass('text-danger');
                }
            });
        })
    </script>
{/block}