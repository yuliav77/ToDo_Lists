document.addEventListener('DOMContentLoaded', function() {

    const submitNewTaskButtons = document.querySelectorAll('.submit_new_task');
    const newTaskInputs = document.querySelectorAll('.task_title');
    const submitNewList = document.querySelector('#submit_new_list');
    const newList = document.querySelector('#list_title');


	if (submitNewTaskButtons){
		submitNewTaskButtons.forEach((el) => {
			el.disabled = true;
		});
	}

	if (newTaskInputs){
		[].forEach.call(newTaskInputs, function(el) {
			el.onkeyup = function(e) {
				if (e.currentTarget.value.length > 0) {
					e.currentTarget.parentNode.querySelector('.submit_new_task').disabled = false;
				}
				else {
					e.currentTarget.parentNode.querySelector('.submit_new_task').disabled = true;
				}
			}			
		});
	}
	
    if (submitNewList) {
		submitNewList.disabled = true;
	}

	if (newList) {
		newList.onkeyup = () => {
			if (newList.value.length > 0) {
				submitNewList.disabled = false;
			}
			else {
				submitNewList.disabled = true;
			}
		}
	}
	
});