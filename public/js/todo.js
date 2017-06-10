/**
 * Add AJAX behaviour to form
 * @param object $form jquery object containing the form dom 
 * @return void
 */
function attachFormSubmitListener($form) {
	$form.on('submit', function(e){
		// Prevent form from submiting
		e.preventDefault();
		var formDataArray = {};
		$.each($form.serializeArray(), function(){
			formDataArray[this.name] = this.value;
		});
		$.ajax({
			url: $form.attr('action'),
			type: $form.attr('method').toLowerCase(),
			cache: false,
			data: formDataArray,
		}).then(function(data){
			if (data.success && data.success == 1) {
				if (data.redirectUrl) {
					window.location.replace(data.redirectUrl);
				} else if ($form.data('redirect-url')) {
					window.location.replace($form.data('redirect-url'));
				} else {
					window.location = "/";
				}
			}
			if (data.error && data.error == 1) {
				if($form.find('.errorPlaceholder')){
					$form.find('.errorPlaceholder')
						.toggleClass('hidden')
						.html(data.msg);
				}
			}
			console.log(data);
		}, function(data){

			// Error Handler
			if(data.responseJSON && data.responseJSON.email) {
				if($form.find('.errorPlaceholder')){
					$form.find('.errorPlaceholder')
						.toggleClass('hidden')
						.html(data.responseJSON.email);
				}
			}

			console.log('error', data.responseJSON);			
		})
		console.log(formDataArray);
	});
}
/**
 * [addTaskItem description]
 * @param {[type]} taskData [description]
 */
function addTaskItemToDom(taskData) {

	console.log(typeof taskData, taskData);

	var taskModel = $('.task-dom').clone()
		.removeClass('task-dom')
		.removeClass('hidden');
	taskModel.find('.task-title-sp').html(taskData.name);
	taskModel.find('.created_at').html(taskData.created_at);

	if(taskData.desc.length) {
		taskModel.find('.task-body')
			.removeClass('hidden')
			.html(taskData.desc);
	}

	taskModel.find('.task-status')
		.addClass('status-'+taskData.status)
		.html(taskData.statusTxt);
	taskModel.data('id', taskData.task_id);

	// Set correct destroy url
	var action = taskModel.find('form').attr('action'),
		editTaskBtn = taskModel.find('.edit-task-btn');

	taskModel.find('form').attr('action', action.replace(/.$/, taskData.task_id));
	editTaskBtn.data('task-id', taskData.task_id);
	editTaskBtn.data('task-name', taskData.name);
	editTaskBtn.data('task-desc', taskData.desc);	

	console.log(taskModel, $('.task-list'));
	taskModel.prependTo('.task-list');
}

$(document).ready(function(){

	$('[data-toggle="tooltip"]').tooltip();

	var jsForms = [
		"#js-login-form",
		"#js-create-list-form"
	];

	jsForms.forEach(function(formSelector){
		if ($(formSelector) && $(formSelector).length) {
			attachFormSubmitListener($(formSelector));
		}
	});

	// Toggle hidden elements on the screen
	if ($('.toggleHiddenElemBtn')) {
		$('.toggleHiddenElemBtn').on('click', function(e){
			e.preventDefault();
			// console.log($(this).data('target'));
			$($(this).data('target')).toggleClass('hidden');
		});
	}

	//Add task form
	if($('#addTaskForm')) {
		$('#addTaskForm').on('submit', function(e) {

			e.preventDefault();

			var formDataArray = {},
				$form = $(this);

			$.each($form.serializeArray(), function(){
				formDataArray[this.name] = this.value;
			});
			$.ajax({
				url: $form.attr('action'),
				type: $form.attr('method').toLowerCase(),
				cache: false,
				data: formDataArray,
			}).then(function(data){
				if (data.success && data.success == 1) {
					$form.find('input[type=text], textarea').val("");
					$form.parent().toggleClass('hidden');
					$.notify(data.msg, 'success');
					
					formDataArray.task_id = data.task_id;
					formDataArray.created_at = data.created_at;
					formDataArray.statusTxt = data.statusTxt;

					addTaskItemToDom(formDataArray);
				}
			}, function(data){

			});
		})
	}
	
	// Delete Task Modal dialog
	$('#deleteTaskModal').on('show.bs.modal', function (event) {
	  // Button that triggered the modal
	  var button = $(event.relatedTarget);
	   // Extract info from data-* attributes
	  var recipient = button.data('whatever');
	  var modal = $(this);

	  $('#confirmTaskDelete').on('click', function(){
	  	button.parent().find('form').submit();
	  });
	})

	//Edit Task Modal Dialog
	$('#editTaskModal').on('show.bs.modal', function(event){
	  // Button that triggered the modal
	  var $button = $(event.relatedTarget),
	  	modal = $(this),
	  	$form = modal.find('form'),
	  	action = $form.attr('action').replace(/.$/, $button.data('task-id'));
	  $form.find('input[name="name"]').val($button.data('task-name'));
	  $form.find('textarea[name=desc]').html($button.data('task-desc'));
	  $form.attr('action', action);
	  $form.find('option[value='+$button.data('task-status')+']').prop('selected', true);

	  $('#confirmTaskEdit').on('click', function(){
	  	$form.submit();
	  });	  
	});

	$('#editListModal').on('show.bs.modal', function(event){

	  var $button = $(event.relatedTarget),
	  	modal = $(this),
	  	$form = modal.find('form');

	  	modal.find('.confirmAction').on('click', function(){
	  		$form.submit();
	  	});
	});

	$('#deleteListRequestModal, #deleteListModal, #archivateModal').on('show.bs.modal', function(event){

	  var $button = $(event.relatedTarget),
	  	modal = $(this),
	  	$form = $button.parent().find('form');

	  	modal.find('.confirmAction').on('click', function(){
	  		$form.submit();
	  	});
	});	

})
