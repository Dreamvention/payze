<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-payment" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-payment" class="form-horizontal">
					<ul class="nav nav-tabs">
						<li class="nav-tab active"><a href="#tab-general" data-toggle="tab"><?php echo $text_tab_general; ?></a></li>
						<li class="nav-tab"><a href="#tab-order-status" data-toggle="tab"><?php echo $text_tab_order_status; ?></a></li>
					</ul>
		  
					<div class="tab-content">
						<div class="tab-pane active" id="tab-general">
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-api-key"><?php echo $entry_api_key; ?></label>
								<div class="col-sm-10">
									<input type="text" name="payze_api_key" value="<?php echo $api_key; ?>" placeholder="<?php echo $entry_api_key; ?>" id="input-api-key" class="form-control" />
									<?php if ($error_api_key) { ?>
									<div class="text-danger"><?php echo $error_api_key; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-api-secret"><?php echo $entry_api_secret; ?></label>
								<div class="col-sm-10">
									<input type="text" name="payze_api_secret" value="<?php echo $api_secret; ?>" placeholder="<?php echo $entry_api_secret; ?>" id="input-api-secret" class="form-control" />
									<?php if ($error_api_secret) { ?>
									<div class="text-danger"><?php echo $error_api_secret; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-general-title"><?php echo $entry_title; ?></label>
								<div class="col-sm-10">
									<?php foreach ($languages as $language) { ?>
									<div class="input-group">
										<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="payze_setting[general][title][<?php echo $language['language_id']; ?>]" value="<?php if (!empty($setting['general']['title'][$language['language_id']])) { ?><?php echo $setting['general']['title'][$language['language_id']]; ?><?php } ?>" placeholder="<?php echo $entry_title; ?>" id="input-general-title-<?php echo $language['language_id']; ?>" class="form-control" />
									</div>
									<?php } ?>
								</div>
                            </div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
									<select name="payze_status" id="input-status" class="form-control">
										<?php if ($status) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-general-preauthorize"><?php echo $entry_preauthorize; ?></label>
								<div class="col-sm-10">
									<select name="payze_setting[general][preauthorize]" id="input-general-preauthorize" class="form-control">
										<?php if ($setting['general']['preauthorize']) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-general-debug"><?php echo $entry_debug; ?></label>
								<div class="col-sm-10">
									<select name="payze_setting[general][debug]" id="input-general-debug" class="form-control">
										<?php if ($setting['general']['debug']) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="payze_total" value="<?php echo $total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
								<div class="col-sm-10">
									<select name="payze_geo_zone_id" id="input-geo-zone" class="form-control">
										<option value="0"><?php echo $text_all_zones; ?></option>
										<?php foreach ($geo_zones as $geo_zone) { ?>
										<?php if ($geo_zone['geo_zone_id'] == $geo_zone_id) { ?>
										<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
								<div class="col-sm-10">
									<input type="text" name="payze_sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-order-status">
							<?php foreach ($setting['order_status'] as $payze_order_status) { ?>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-order-status-<?php echo $payze_order_status['code']; ?>"><?php echo ${$payze_order_status['name']}; ?></label>
								<div class="col-sm-10">
									<select name="payze_setting[order_status][<?php echo $payze_order_status['code']; ?>][id]" id="input-order-status-<?php echo $payze_order_status['code']; ?>" class="form-control">
										<?php foreach ($order_statuses as $order_status) { ?>
										<?php if ($order_status['order_status_id'] == $payze_order_status['id']) { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>