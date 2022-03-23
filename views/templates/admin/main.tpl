{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 *}

<div class="row gr-settings-top">
	<div class="col-lg-8 col-lg-offset-2">
		<div class="panel">
			<div class="h1"><span>GetResponse</span> for PrestaShop</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					<p>Start expanding your contact list right away. Add new contacts and update information on your existing subscribers. Gain more insight into what they buy and what pages they visit before and after their purchase. Create personalized customer journey based on the data you collect.</p>
					<p>Manage the PrestaShop integration directly in your GetResponse account. To view and edit the integration, go to the integration setup page in GetResponse.</p>
					<a class="btn btn-primary" href="https://app.getresponse.com/integrations/prestashophybrid" target="_blank">Go to GetResponse</a>
				</div>
			</div>
		</div>
	</div>
</div>

{foreach $getresponse_settings as $shop_name => $settings}
<div class="row">
	<div class="col-lg-8 col-lg-offset-2">
		<div class="panel gr-settings-shop">
			<div class="h3"><span>{$shop_name|escape:'htmlall':'UTF-8'}</span> shop configuration</div>

			<div class="form-wrapper">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="form-group row">
							<div class="col-sm-4 text-right"><div class="form-control-label">Facebook Pixel</div></div>
							<div class="col-sm-8">
								{if $settings['fb_pixel'] === true}<span class="label label-success">Enabled</span>{else}<span class="label label-default">Disabled</span>{/if}
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-4 text-right"><div class="form-control-label">Facebook Ads Pixel</div></div>
							<div class="col-sm-8">
								{if $settings['fb_ads_pixel'] === true}<span class="label label-success">Enabled</span>{else}<span class="label label-default">Disabled</span>{/if}
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="form-group row">
							<div class="col-sm-4 text-right"><div class="form-control-label">Tracking code</div></div>
							<div class="col-sm-8">
								{if $settings['gr_tracking'] === true}<span class="label label-success">Enabled</span>{else}<span class="label label-default">Disabled</span>{/if}
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-4 text-right"><div class="form-control-label">Live synchronization</div></div>
							<div class="col-sm-8">
								{if $settings['live_synchronization'] === true}<span class="label label-success">Enabled</span>{else}<span class="label label-default">Disabled</span>{/if}
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="form-group row">
							<div class="col-sm-4 text-right"><div class="form-control-label">Web Form</div></div>
							<div class="col-sm-8">
								{if $settings['web_form'] === true}<span class="label label-success">Enabled</span>{else}<span class="label label-default">Disabled</span>{/if}
							</div>
						</div>

						{if $settings['fbe'] === true}
						<div class="form-group row">
							<div class="col-sm-4 text-right"><div class="form-control-label">Facebook Business Extension</div></div>
							<div class="col-sm-8">
								<span class="label label-success">Enabled</span>
							</div>
						</div>
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{/foreach}

<style>
	.gr-settings-top p {
		margin-bottom: 25px;
		font-size: 11pt;
	}
	.gr-settings-top .button-primary {
		background: #00AFEC;
	}
	.gr-settings-top .btn {
		padding: 10px 20px;
	}
	.gr-settings-top .h1 span {
		color: #00AFEC;
	}
	.gr-settings-top .panel {
		background: url({$shop_name|escape:'htmlall':'UTF-8'}views/img/back.jpeg) no-repeat bottom right;
	}
	.gr-settings-shop .h3 {
		padding-bottom: 20px;
		margin-top: 0;
	}
	.gr-settings-shop .h3 span {
		color: #00AFEC;
	}
</style>