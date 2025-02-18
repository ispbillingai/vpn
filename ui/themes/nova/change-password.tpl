{include file="sections/header.tpl"}

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="panel panel-primary panel-hovered panel-stacked mb30">
										                <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{Lang::T('Change Password')}</span>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#tutorialModal" style="margin-left: auto;">
                        {Lang::T('Need Help?')}
                    </button>
                </div>
						<div class="panel-body">
						<form class="form-horizontal" method="post" role="form" action="{$_url}settings/change-password-post">
							<div class="form-group">
								<label class="col-md-2 control-label">{Lang::T('Current Password')}</label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="password" name="password">
								</div>
							</div>
							<div class="form-group">
									<label class="col-md-2 control-label">{Lang::T('New Password')}</label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="npass" name="npass">
								</div>
							</div>
							<div class="form-group">
							<label class="col-md-2 control-label">{Lang::T('Confirm New Password')}</label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="cnpass" name="cnpass">
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
															<button class="btn btn-success" type="submit">{Lang::T('Save Changes')}</button>
									Or <a href="{$_url}dashboard">{Lang::T('Cancel')}</a>
								</div>
							</div>
						</form>
				
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="tutorialModal" tabindex="-1" role="dialog" aria-labelledby="tutorialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tutorialModalLabel">Tutorial Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/M91aZf1wrEw?si=f3cxhNtD6wDbMBwz" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


{include file="sections/footer.tpl"}
