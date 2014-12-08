{extends file='base_layout.tpl'}
{block name=head}
{css}
{js position='head'}
{/block}
{block name=body}
    {bs_container display=table}
        {row}
            {col}
                <!-- nav -->
                <nav>
                  <a class="divide">
                    . . .
                  </a>
                  <a class="language" href="" data-toggle="tooltip" data-placement="right" title="Tooltip on right">
                    <picture>
                        1
                    </picture>
                  <a class="logoout" href="{site_url url='welcome/logout'}" data-toggle="tooltip" data-placement="right" title="Tooltip on right">
                    <picture>
                        2
                    </picture>
                  </a>
                </nav>
                 <!-- end nav -->
            {/col}
            {col id='main'}
               {table_container}
                    {table_row}
                        {table_col}
                            <!-- header -->
                            <div id="header" class="row">
                                sds
                            </div>
                            <!-- end  header -->
                        {/table_col}
                    {/table_row}
                    {table_row}
                        {table_col}
                            <!-- toolbar -->
                            <div id="toolbar" class="row">
                                <div  class="col-1280-12">
                                    {button show=green class=save}Save{/button}
                                    {button show=green class=cancel}Cancel{/button}
                                    <div class="faq" data-toggle="tooltip" data-placement="bottom" title="Tooltiponbottomssadsadasdasdsdsdsdsddsdasdasdasdasdasdsdsdsdasdsds">
                                        ?
                                    </div>
                                </div>
                            </div>
                            <!-- end toolbar -->
                        {/table_col}
                    {/table_row}
                    {table_row}
                        {table_col class="full-height"}
                            <!-- content -->
                            <div id="content" class="row">
								<div class="col-1280-12">
                                    <button type="button" id="myButton" data-loading-text="Loading..." class="btn btn-primary" autocomplete="off">
                                      Loading state
                                    </button>
									<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
									  Single toggle
									</button>
									<button type="button" id="myStateButton" data-complete-text="finished!" class="btn btn-primary" autocomplete="off">
									  ...
									</button>
								</div>
                            </div>
                            <!--  end content -->
                        {/table_col}
                    {/table_row}
                {/table_container}
            {/col}
        {/row}
    {/bs_container}
{/block}
{block name=foot}
{js}
{init_js}
<script type="text/javascript">
	function initialise() {
		  $('#myStateButton').on('click', function () {
		    $(this).button('complete') // button text will be "finished!"
		  })
	}
</script>
{/block}
