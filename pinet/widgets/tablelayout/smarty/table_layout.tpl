{extends file='base_layout.tpl'}
{block name=head}
{css}
{/block}
{block name=body append}
  	{bs_container display=table}
		{row}
			{col id="navigation"}
				{block name=navigations}{** This is the location for navigations **}{/block}
			{/col}
			{col id="main"}
				{table_container}
					{table_row id="header"}
						{table_col}
							{if $has_head}
							{block name=statebar}{** The state bar of the layout **}{/block}
							{/if}
						{/table_col}
					{/table_row}
					{table_row id="content"}
						{table_col}
							{table_container}
								{table_row}
									{table_col id="workbench"}
										{table_container}
											{table_row}
												{table_col}
													{block name=toolbar}{** The state bar of the layout **}{/block}
												{/table_col}
											{/table_row}
											{table_row}
												{table_col}
													{block name=messagebar}{** The state bar of the layout **}{/block}
												{/table_col}
											{/table_row}
											{table_row class="last"}
												{table_col}
													{block name=workbench}{** The workbench of the layout **}{/block}
												{/table_col}
											{/table_row}
										{/table_container}
									{/table_col}
									{table_col id="side"}
										{if $has_head}
										{block name=aside}{** The side bar of the layout **}{/block}
										{/if}
									{/table_col}
								{/table_row}
							{/table_container}
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
{/block}
