{*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

			
			{if $page_name == 'index'}
				<div id="cs_home_center_bottom" class="grid_24 alpha omega">
				{if $HOOK_CS_HOME_LEFT}
					<div id="cs_home_center_bottom_left" class="grid_18 alpha">
						{$HOOK_CS_HOME_LEFT}
					</div>
				{/if}
				{if $HOOK_CS_HOME_RIGHT}
					<div id="cs_home_center_bottom_right" class="grid_6 omega">
						{$HOOK_CS_HOME_RIGHT}
					</div>
				{/if}
				</div>
			{/if}
			{if !$content_only}
					</div><!-- /Center -->
			{if isset($settings)}
				{if $page_name != 'index'}
					{if (($settings->column == '2_column_right' || $settings->column == '3_column'))}
						<!-- Left -->
						<div id="right_column" class="{$settings->right_class} omega">
							{$HOOK_RIGHT_COLUMN}
						</div>
						{if $settings->column == '3_column'}
						<script type="text/javascript">
							if($("#right_column").children("#layered_block_left").length>0)
							{
								$("#right_column").children("#layered_block_left").css("display","none");
								$("#right_column").children("#layered_block_left").remove();
							}
						</script>
						{/if}
					{/if}
				{/if}
			{/if}
				</div><!--/columns-->
			</div><!--/container_24-->
			</div>
<!-- Footer -->
			<div class="mode_footer">
					<div class="container_24">	
						{if $HOOK_CS_FOOTER_TOP}
							<div id="footer-top" class="grid_24 clearfix  omega alpha">
								{$HOOK_CS_FOOTER_TOP}
							</div>
						{/if}
						<div id="footer" class="grid_24 clearfix  omega alpha">
							{$HOOK_FOOTER}
							{if $PS_ALLOW_MOBILE_DEVICE}
								<p class="center clearBoth"><a href="{$link->getPageLink('index', true)}?mobile_theme_ok">{l s='Browse the mobile site'}</a></p>
							{/if}
						</div>						
					</div>
					{if $HOOK_CS_FOOTER_BOTTOM}
					<div class="mode_footer_content_bottom">
						<div class="cs_bo_footer_bottom">
						<div id="footer-bottom" class="container_24">
							{$HOOK_CS_FOOTER_BOTTOM}
						</div>
						</div>
					</div>
					{/if}
			</div>
		</div><!--/page-->
	{/if}
	</body>
</html>
