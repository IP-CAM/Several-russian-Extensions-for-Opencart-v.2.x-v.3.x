<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $setting; ?>" data-toggle="tooltip" title="<?php echo $button_setting; ?>" class="btn btn-primary"><i class="fa fa-cog"></i>&nbsp;<?php echo $button_setting; ?></a>
				<a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-success"><i class="fa fa-plus"></i></a>
				<button type="submit" form="form-events" formaction="<?php echo $hideEvent ?>" data-toggle="tooltip" title="<?php echo $button_hideEvent ?>" class="btn btn-default"><i class="fa fa-eye-slash"></i></button>
				<button type="submit" form="form-events" formaction="<?php echo $copy; ?>" data-toggle="tooltip" title="<?php echo $button_copy; ?>" class="btn btn-default"><i class="fa fa-copy"></i></button>
				<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-events').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if ($success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-events">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
									<td class="center"><?php echo $column_image; ?></td>
									<td class="center"><?php if ($sort == 'nd.title') { ?>
										<a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
									<?php } ?></td>
									<td class="center"><?php if ($sort == 'n.date_to') { ?>
										<a href="<?php echo $sort_date_to; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_to; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_date_to; ?>"><?php echo $column_date_to; ?></a>
									<?php } ?></td>
									<td class="center"><?php echo $column_date_from; ?></td>
									<td class="left"><?php echo $column_status; ?></td>
									<td class="right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($events) { ?>
								<?php $class = 'odd'; ?>
								<?php foreach ($events as $events_story) { ?>
								<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
								<tr class="<?php echo $class; ?>">
									<td align="center">
										<?php if ($events_story['selected']) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $events_story['event_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $events_story['event_id']; ?>" />
										<?php } ?>
									</td>
									<td class="center"><img src="<?php echo $events_story['image']; ?>" alt="<?php echo $events_story['title']; ?>" style="padding: 1px; border: 1px solid #DDD;" /></td>
									<td class="left"><?php echo $events_story['title']; ?></td>
									<td class="left"><?php echo $events_story['date_to']; ?></td>
									<td class="left"><?php echo $events_story['date_from']; ?></td>
									<td class="left"><?php echo $events_story['status']; ?></td>
				                	<td class="text-right"><a href="<?php echo $events_story['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>	
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr class="even">
									<td class="center" colspan="7"><?php echo $text_no_results; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</form>
				<div class="row">
					<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
					<div class="col-sm-6 text-right"><?php echo $results; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>