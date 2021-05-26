const Toast = Swal.mixin({
	toast: true,
	position: 'center',
	showConfirmButton: false,
	timer: 5000,
	padding: '2em',
	timerProgressBar: true,
	didOpen: (toast) => {
		toast.addEventListener('mouseenter', Swal.stopTimer)
		toast.addEventListener('mouseleave', Swal.resumeTimer)
	}
});

(function show_paswd_fun(){
	let show_paswd = document.querySelectorAll('.show_paswd_wrapp');
	let st_func;
	show_paswd.forEach((item) => {
		item.addEventListener('click', (e)=>{
		if(e.target.classList.contains('showing_paswd')){
			e.target.classList.remove('showing_paswd');
			item.innerHTML='<span class="material-icons show_paswd_icon md-18">visibility</span>';
			e.target.parentElement.querySelector('input[type=text]').setAttribute('type', 'password');
			clearTimeout(st_func);
		}else{
			console.log('showing paswd... for 10s');
			e.target.parentElement.querySelector('input[type=password]').setAttribute('type', 'text');
			e.target.classList.add('showing_paswd');
			item.innerHTML = '<div class="timer_wrap"><span class="niddle"></span></div>';
			st_func = setTimeout(() => {
				if(item.querySelector('.timer_wrap') != null){
			  		item.innerHTML='<span class="material-icons show_paswd_icon md-18">visibility</span>';
					e.target.parentElement.querySelector('input[type=text]').setAttribute('type', 'password');
					e.target.classList.remove('showing_paswd');
			}
			}, 10000);
		}
	}); 
	});
})();

(()=>{
	let right_checkbox = document.querySelectorAll('.right_aside_wrap .checkbox');
	if(right_checkbox.length == 0) return false;
	right_checkbox.forEach(element => {
		if(localStorage[element.id]){
		  // fetching previous state
		  element.checked = (localStorage[element.id] == 'true')? true : false;
		}
		element.addEventListener('change', function() {
			  // Store
			  localStorage[this.id] = this.checked;
			  console.log(localStorage);
		  });
		
	});
})();

(function subject_name_event_list() {
	let input = document.getElementById('new_note_subject');
	if (input == null) {
		return false;
	}
	let subject_inputed, suggested_div;
	input.addEventListener('input', (e) => {
		subject_inputed = e.target.value.trim();
		if (subject_inputed.length > 1) {
			ajax_form_process.set_dynamic_values({
				e: '',
				form_id: '',
				which_form: 'search_suggestion_subject_name',
				input: subject_inputed
			});
			ajax_form_process.call_of_ajax({
				e: '',
				has_form: false
			});
		} else {
			search_suggestion.reset_suggestion('subject_suggestion');
		}
	}, false);

	input.addEventListener('blur', () => {
		suggested_div = document.querySelector('.subject_suggestion');
		if (suggested_div != null) {
			/*
			 *IMPORTANT :
			 *Do not remove the setTimeout()
			 **/
			setTimeout(() => {
				suggested_div.remove();
			}, 150);
		}
	}, false);
})();


(function search_notes_event_listener() {
	let input = document.querySelector('.input_search_close_wrap .search_top_header');
	if (input == null) {
		return false;
	}
	let inputed_value, suggested_div, select_option;
	let access_for = document.querySelector('.search_options_sel');
	input.addEventListener('input', (e) => {
		inputed_value = e.target.value.trim();
		if (inputed_value.length > 1) {
			if (access_for != null) {
				select_option = access_for.value;
			}
			ajax_form_process.set_dynamic_values({
				e: '',
				form_id: '',
				which_form: 'search_suggestion_notes',
				input: inputed_value,
				access_for: select_option
			});
			ajax_form_process.call_of_ajax({
				e: '',
				has_form: false
			});
		} else {
			search_suggestion.reset_suggestion('search_sugg_notes');
		}
	}, false);

	input.addEventListener('blur', () => {
		suggested_div = document.querySelector('.search_sugg_notes');
		if (suggested_div != null) {
			/*
			 *IMPORTANT :
			 *Do not remove the setTimeout()
			 **/
			setTimeout(() => {
				//suggested_div.remove();	
			}, 150);
		}
	}, false);
})();

function get_url_file_name() {
	let href = window.location.href
	index = href.lastIndexOf("/") + 1;
	return href.slice(index);
}

function url_has_params(url) {
	return url.includes('?'); // true/false
}

function get_url_params(url, param_name) {
	let url_string = url;
	url = new URL(url_string);
	if (url.searchParams.has(param_name)) {
		return url.searchParams.get(param_name);
	}
	// If url does not has a requested parameter.
	return false;
}

function server_error_msg_AJAX(message) {
	let html = `<div id="server_error_message_AJAX">
					<span class="s_e_m_AJAX_img">
					<img src="../images/emblem_important_symbolic1.svg">
					</span>
					<span class="server_error_msg_wrap">
					<span class="server_error_message">${message}</span>
					</span>
				</div>`
	return html;
}


function add_hacking_anim(obj = {}) {
	obj['elements'].forEach((element, index) => {
		setTimeout(() => {
			element.classList.add(obj['class_name']);
		}, obj['multiple_time'] * index);
	});
}

function shake_element(class_name) {
	anime({
		targets: [class_name],
		translateX: [20, 0, -20, 0, 20, 0, -20, 0],
		easing: 'linear',
		duration: 400
	});
}

function goBack() {
	window.history.back();
}

function reset_by_class_name(class_name = "") {
	if (class_name != "") {
		let element = document.querySelectorAll('.' + class_name);
		if (element.length > 0) {
			element.forEach(element => {
				element.remove();
			});
		} else {
			return;
		}
	}

}


function animate_by_anime(obj={}){
	let anim_obj = {};
	for(i in obj){
		if( i=='targets' || i=='scale' || i=='translateX' || i=='translateY' || i=='opacity' || i=='easing' || i=='duration' || i=='delay' ) {
			anim_obj[i]=obj[i];
		}
	}
	anime(anim_obj);
}

function url_array(url = '', last_check = '', last_second_check = '') {
	if (url.trim() == '') {
		var url = window.location.href;
	}
	var pathname = new URL(url).pathname;
	let url_array = pathname.split('/');
	// removing the last array element if it is empty
	if (url_array[url_array.length - 1] == '') {
		url_array.pop();
	}
	if (last_check.trim() != '') {
		// checking the last index from the array url with the `check` parameter.
		if (url_array[url_array.length - 1] === last_check) {
			if (last_second_check.trim() != '') {
				if (url_array[url_array.length - 2] === last_second_check) {
					return true;
				}
			}
			return true;
		} else {
			return false;
		}
	} else {
		return url_array;
	}
}

function animate_by_JS_library() {
	let file_name = get_url_file_name();
	switch (file_name) {
		case 'about':
			if(screen.width > 500){
			anime({
				targets: '.user_image.user_image_first',
				translateX: [150, 0],
				delay: 500,
				easing: 'easeInOutSine'
			});
			anime({
				targets: '.user_image.user_image_second',
				translateX: [-150, -1],
				delay: 500,
				easing: 'easeInOutSine'
			});
			anime({
				targets: '.user_name_about_wrap',
				opacity: [0, 1],
				delay: 400,
				scale: [0, 1],
				easing: 'linear'
			});
		}
			break;
		case 'tags':
			anime({
				targets: '.notes_tag_link',
				scale: [0.9, 1],
				opacity: [0, 1],
				delay: function (el, i) {
					return i * 100;
				}
			});
			break;
	}
}

function ajax_loader(obj, css_styles = true) {
	if (obj['align'] != 'center' || obj['align'] != 'right' || obj['align'] != 'left') {
		obj['align'] = 'center';
	}
	if (css_styles == true) {
		var styles = "display: block; text-align:"+ obj['align'];
	} else {
		var styles = '';
	}
	return `<span class="ajax_loader1" style="${styles}">
                <img src="${obj['img_loc']}" alt="Loader image">
               </span>`;
}

function remove_ajax_loader() {
	document.querySelectorAll('.ajax_loader1').forEach(element => {
		element.remove();
	});
}

function remove_class_name(element, class_to_remove) {
	let element__ = document.querySelector(element);
	if (element__ != null) {
		element__.classList.remove(class_to_remove);
	}
}
/**
 * [remove_class_name_multiple_ele description]
 * @param  {[type]} element         [from which element to remove that class name. eg, header, section]
 * @param  {[type]} class_to_remove [the class name which you want to remove]
 */
function remove_class_name_multiple_ele(element, class_to_remove) {
	let wrapper = document.querySelector(element);
	let remove_from = wrapper.querySelectorAll('.' + class_to_remove);
	if (remove_from.length > 0) {
		remove_from.forEach((item) => {
			item.classList.remove(class_to_remove);	  
		});
	}
}


function show_menus_short() {
	let div_info = document.querySelector('.top_nav_menu_info_wrap');
	if (div_info != null) {
		if (div_info.classList.contains('show')) {
			div_info.classList.remove('show');
			document.querySelector('.burger_icon_wrap .burger_icon').textContent = 'expand_less';
		} else {
			div_info.classList.add('show');
			document.querySelector('.burger_icon_wrap .burger_icon').textContent = 'expand_more';
		}
	}
}

/* PARAMS  -
 * obj= {msg,id,hide_time,auto_hide}
 */
function show_alert_msg_ajax(obj) {
	let html = `<div class="ajax_popup_message_wrap" id="${obj['id']}">
				${obj['msg']}
				</div>`;

	document.body.insertAdjacentHTML('beforeend', html);
	// adding animation class to hide the element after N seconds.
	if (obj['auto_hide'] == true) {
		let popuped_element = document.getElementById(obj['id']);
		if (popuped_element == null) {
			return false;
		}
		setTimeout(() => {
			popuped_element.classList.add('hide_anim_popup');
		}, obj['hide_time']);
		// Removing element
		setTimeout(() => {
			popuped_element.remove();
		}, obj['hide_time'] + 500);
	} //if
}

// add_close_action_event({close_btn:'',element_to_remove:''})
function add_close_action_event(obj = {}) {
	let close_btn = document.querySelector(obj.close_btn);
	if (close_btn == null) {
		return false;
	}

	close_btn.addEventListener('click', (e) => {
		anime({
			targets: '.otp_form .sucess_otp_wrap',
			scale: [1, 0.5],
			opacity: [1, 0],
			translateY: -100,
			easing: 'easeOutExpo',
			duration: 500,
			custom_f: setTimeout(() => {
				close_btn.closest(obj.element_to_remove).remove();
			}, 500)

		});
	}, false);
}

function compare_arrays(a, b){
	return a.length === b.length && a.every((value, index) => value === b[index])
}
function get_unique_array(arr){
	return [... new Set(arr)];
}
function strip_html(html){
	return html.replace(/(<([^>]+)>)/gi, "");
}
function ajax_call(obj={}){
	ajax_form_process.set_dynamic_values(obj.d_values);
	ajax_form_process.call_of_ajax(obj.xhr_values, obj['multiple_request']);
}
function popup_close_outside_clicks(outside_element, class_name, close_btn){
	let outside = document.querySelector(outside_element);
	let close_btn_ = document.querySelector(close_btn);
	outside.addEventListener('click', (e) => {
		e.stopImmediatePropagation();
		if(e.target.classList.contains(class_name)){
			close_btn_.click();
		}
	});

}
function show_save_note_form_data_errors(json){
	for (let i in json.errors) {
		switch (i) {
			case 'topic':
				document.querySelector('.new_note_topic_input .span_input_wrap').insertAdjacentHTML('beforeend', `<span class="form_errors form_errors_input">${json.errors[i]}<span>`);
				break;

			case 'subject':
				document.querySelector('.new_note_subject_input .span_input_wrap').insertAdjacentHTML('beforeend', `<span class="form_errors form_errors_input">${json.errors[i]}<span>`);
				break;

			case 'tag':
				document.querySelector('.new_note_tag_input .span_for_align_tag').insertAdjacentHTML('beforeend', `<span class="form_errors form_errors_input">${json.errors[i]}<span>`);
				break;

			case 'access_type':
				document.querySelector('.new_note_access_type_inner .span_input_wrap').insertAdjacentHTML('beforeend', `<span class="form_errors form_errors_input">${json.errors[i]}<span>`);
				break;

			case 'note_markdown':
				document.querySelector('.note_textarea_wrap .c_note_help_tiny').insertAdjacentHTML('beforebegin', `<span class="form_errors form_errors_textarea">${json.errors[i]}<span>`);
				break;
				
			default:
				// statements_def
				break;
		}
	}
}

// function add_anim_in_tags_dot_php_page(){
// 	let nt = document.querySelectorAll('');
// 	setTimeout(()=>{
// 	add_hacking_anim({elements:nt, class_name:'moving_color',multiple_time:20});
// }, 1000);
// }

function add_anim_in_suggestion(obj = {}) {
	let elems = document.querySelectorAll(obj['class_name']);
	setTimeout(() => {
		add_hacking_anim({
			elements: elems,
			class_name: obj['animation_name'],
			multiple_time: obj['multiple_time']
		});
	}, obj['set_time']);
}

function resetCreateNewForm(form_id) {
	let preview_tags = document.querySelector('.preview_all_tags');
	let parse_md = document.getElementById('wmd-preview');
	let form = document.getElementById(form_id);
	if (parse_md != null) {
		parse_md.textContent = null;
	}
	if (preview_tags != null) {
		preview_tags.textContent = null;
	}
	if (form != null) {
		form.reset();
	}
}

function filter_by_regex(unfiltered, regex){
	if(!regex){
		regex = /[\w]+/;
	}
	return unfiltered.match(regex);
}

/**
 * [click_event_on_delete_btn_on_popup description]
 * adding click evenet on delete button present in popup. 
 */
function click_event_on_delete_btn_on_popup(note_to_delete_element){
	if(!note_to_delete_element.classList.contains('note_wrap')){
		return false;
	}
	let delete_btn = note_to_delete_element.querySelector('.note_delete_wrap');
	let close_btn = document.querySelector('.edited_note_confirmation_user_box_wrap .confirmation_close_btn');
	let delete_btn_on_popup = document.querySelector('.confirmation_header_body_wrap .note_delete_wrap');
	if(close_btn != null && delete_btn != null){
		delete_btn_on_popup.addEventListener('click', () => {
			// closing popuped note.
			close_btn.click();
			// in css scale out animation is set to 0.5s.
			// so after 0.5s we will show next popup for delete note.
			// If you decrease the time then some click events will not work.
			// If you really want to decrease time then first decrease time in 
			// close_btn.click(); and then below
			setTimeout(() => {
			  delete_btn.click();
			}, 520);
		});
	}
}
///////////////////////
// ABOVE IS FUNCTION //
///////////////////////

class active_navbar {
	active_navbar = '';
	static show_active_navbar() {
		this.url_array = url_array();
		switch (this.url_array[this.url_array.length - 1]) {
			case 'user_notes':
				this.active_navbar = document.querySelector('.top_header_navbar .home_navbar');
				this.active_navbar.parentElement.classList.add('active_navbar');
				this.active_navbar.classList.add('white_color_link');
				this.active_navbar.style.backgroundColor = run_setup.active_navbar_bg_color;
				break;

			case 'about':
				this.active_navbar = document.querySelector('.top_header_navbar .about_navbar');
				this.active_navbar.parentElement.classList.add('active_navbar');
				this.active_navbar.classList.add('white_color_link');
				this.active_navbar.style.backgroundColor = run_setup.active_navbar_bg_color;
				break;

			case 'notes':
				this.active_navbar = document.querySelector('.top_header_navbar .notes_navbar');
				this.active_navbar.parentElement.classList.add('active_navbar');
				this.active_navbar.classList.add('white_color_link');
				this.active_navbar.style.backgroundColor = run_setup.active_navbar_bg_color;
				break;

			case 'subjects':
				this.active_navbar = document.querySelector('.top_header_navbar .subjects_navbar');
				this.active_navbar.parentElement.classList.add('active_navbar');
				this.active_navbar.classList.add('white_color_link');
				this.active_navbar.style.backgroundColor = run_setup.active_navbar_bg_color;
				break;

			case 'topic':
				this.active_navbar = document.querySelector('.top_header_navbar .topics_navbar');
				this.active_navbar.parentElement.classList.add('active_navbar');
				this.active_navbar.classList.add('white_color_link');
				this.active_navbar.style.backgroundColor = run_setup.active_navbar_bg_color;
				break;

			case 'tags':
				this.active_navbar = document.querySelector('.top_header_navbar .tags_navbar');
				this.active_navbar.parentElement.classList.add('active_navbar');
				this.active_navbar.classList.add('white_color_link');
				this.active_navbar.style.backgroundColor = this.text_active_color;
				this.active_navbar.style.backgroundColor = run_setup.active_navbar_bg_color;
				break;

			case 'watch_later':
				this.active_navbar = document.querySelector('.top_header_navbar .watch_later_navbar');
				this.active_navbar.parentElement.classList.add('active_navbar');
				this.active_navbar.classList.add('white_color_link');
				this.active_navbar.style.backgroundColor = run_setup.active_navbar_bg_color;
				document.querySelector('.top_header_navbar .more_navbar').parentElement.parentElement.classList.add('active_navbar');
				document.querySelector('.top_header_navbar .more_navbar').style.backgroundColor = run_setup.active_navbar_bg_color;
				document.querySelector('.top_header_navbar .more_navbar');

				break;

			case 'important_notes':
				this.active_navbar = document.querySelector('.top_header_navbar .imp_notes_navbar');
				this.active_navbar.parentElement.classList.add('active_navbar');
				this.active_navbar.classList.add('white_color_link');
				this.active_navbar.style.backgroundColor = run_setup.active_navbar_bg_color;
				document.querySelector('.top_header_navbar .more_navbar').parentElement.parentElement.classList.add('active_navbar');
				document.querySelector('.top_header_navbar .more_navbar').style.backgroundColor = run_setup.active_navbar_bg_color;
				document.querySelector('.top_header_navbar .more_navbar').classList.add('white_color_link');
				break;
		} // switch
	}
}

class markdownFormatingTips {
	container = document.querySelector('.form_create_new_note_bottom_center_align .formating_markdown_help');
	container_height;
	btn = document.querySelector('.form_create_new_note_bottom_center_align .show_formating_help');
	default_btn_value = (this.btn != null) ? this.btn.textContent : '';
	toggled_btn_value = 'hide formating tips';
	is_container_visible = false;
	first_time = true;

	animate_height_md_container(start, end) {
		anime({
			targets: this.container,
			height: [start, end],
			easing: 'easeInOutQuad'
		});
	}

	add_click_eve_on_btn() {
		if (this.btn != null) {
			this.btn.addEventListener('click', (e) => {
				if (!this.is_container_visible) {
					this.btn.textContent = this.toggled_btn_value;
					this.container.classList.remove('hide');
					this.container.classList.add('show');
					this.is_container_visible = true;
					if (this.first_time) {
						this.container_height = this.container.offsetHeight + 10;
						this.first_time = false;
						this.add_eve_on_tabs();
					}

					this.animate_height_md_container(0, this.container_height);

					anime({
						targets: '.f_help_child',
						translateY: [-20, 0],
						delay: anime.stagger(100) // increase delay by 100ms for each elements.
					});
				} else {
					this.btn.textContent = this.default_btn_value;
					this.container.removeAttribute('style');
					this.reset_tab_styles();
					this.container.classList.remove('show');
					anime({
						targets: this.container,
						height: [this.container_height, 0],
						easing: 'easeInOutQuad',
						duration: 200
					});

					// this.container.classList.add('hide');
					this.is_container_visible = false;
				}
			}, false);
		}
	}

	add_eve_on_tabs() {
		let header_container = document.querySelector('.formating_header');
		if (header_container != null) {
			header_container.addEventListener('click', (e) => {
				if (e.target.classList.contains('f_help_text')) {
					if (!e.target.classList.contains('active_tab')) {
						// remove previous active tab
						header_container.querySelector('.active_tab').classList.remove('active_tab');
						e.target.classList.add('active_tab');
						this.container.querySelector('.f_body_help_art.show').classList.add('hide');
						this.container.querySelector('.f_body_help_art.show').classList.remove('show');
						this.container.querySelectorAll('.formating_markdown_help_body .f_body_help_art')[e.target.getAttribute('data-tab-id') - 1].classList.add('show');
						this.container.querySelectorAll('.formating_markdown_help_body .f_body_help_art')[e.target.getAttribute('data-tab-id') - 1].classList.remove('hide');
						this.previous_container_height = this.container_height;
						this.container_height = this.container.querySelectorAll('.formating_markdown_help_body .f_body_help_art')[e.target.getAttribute('data-tab-id') - 1].offsetHeight + this.container.querySelector('.formating_markdown_help .formating_header').offsetHeight + 12;
						anime({
							targets: this.container,
							height: [this.previous_container_height, this.container_height],
							easing: 'easeInOutQuad',
							duration: 100
						});
					}
				}
			}, false);
		}
	}

	reset_tab_styles() {
		let tabs = document.querySelectorAll('.formating_header .f_help_child');
		if (tabs.length != 0) {
			tabs.forEach(element => {
				element.removeAttribute('style');
			});
		}
	}

	show_formating_container() {

	}

}

class runSetup {
	url_file_name = '';
	active_navbar_bg_color = '#f7f8fc';
	runFirstFunctions() {
		animate_by_JS_library();
		active_navbar.show_active_navbar();
		let md_formating_tips = new markdownFormatingTips;
		md_formating_tips.add_click_eve_on_btn();
		this.url_file_name = get_url_file_name();
	}
}

var run_setup = new runSetup;
run_setup.runFirstFunctions();



class UserFormAccess {
	is_form_visible = false;
	signup_btn = document.querySelector('.main_top_header .signup_btn');
	signin_btn = document.querySelector('.main_top_header .signin_btn');
	login_form = document.querySelector('.login_art');
	signup_form = document.querySelector('.reg_art');
	login_close_btn = document.querySelector('.login_close_btn');
	signup_close_btn = document.querySelector('.reg_close_btn');
	back_to_signup = document.querySelector('.back_to_sinup span');
	back_to_login = document.querySelector('.back_to_login span');
	dim_bg = document.querySelector('.dimlight');

	show_hide_dim_bg() {
		if (this.is_form_visible) {
			this.dim_bg.style.display = "none";
			console.log('hide dim light');
			return;
		}
		this.dim_bg.style.display = "block";
	}

	hide_login_form() {
		this.show_hide_dim_bg();
		//this.login_form.classList.add('popup_hide_anim');
		animate_by_anime({
			targets: [this.login_form],
			scale: [1,1.2],
			opacity:[1,0],
			easing: 'cubicBezier(.25,.1,.25,1)',
			duration: 500
		});
		setTimeout(() => {
			this.login_form.classList.remove('login_art_flex');
			//this.login_form.classList.remove('popup_hide_anim');
		}, 500);
		this.is_form_visible = false;
	}

	hide_signup_form() {
		this.show_hide_dim_bg();
		//this.signup_form.classList.add('popup_hide_anim');
		animate_by_anime({
			targets: [this.signup_form],
			scale: [1,1.2],
			opacity:[1,0],
			easing: 'cubicBezier(.25,.1,.25,1)',
			duration: 500
		});
		setTimeout(() => {
			this.signup_form.classList.remove('reg_art_flex');
			//this.signup_form.classList.remove('popup_hide_anim');
		}, 500);
		this.is_form_visible = false;
	}

	show_login_form() {
		if (this.is_form_visible) {
			this.hide_signup_form();
		}
		this.show_hide_dim_bg();
		this.login_form.classList.add('login_art_flex');
		animate_by_anime({
			targets: '.login_art_flex',
			scale: [1.2,1],
			opacity:'1',
			easing: 'cubicBezier(.25,.1,.25,1)',
			duration: 200
		});
		this.is_form_visible = true;
	}

	show_signup_form() {
		if (this.is_form_visible) {
			this.hide_login_form();
		}
		this.show_hide_dim_bg();
		this.signup_form.classList.add('reg_art_flex');
		animate_by_anime({
			targets: '.reg_art_flex',
			scale: [1.2,1],
			opacity:'1',
			easing: 'cubicBezier(.25,.1,.25,1)',
			duration: 200
		});
		this.is_form_visible = true;
	}
} /* class UserFormAccess*/

class CommonAjaxFunctions {
	default_form_btn_text_process = 'Please wait...';
	show_loading(obj) {
		if (typeof obj.e != 'object') {
			switch (obj.e) {
				case 'all_notes_art_wrap':
					if (window.location.href.search('user/notes') >= 0) {
						remove_ajax_loader();
						show_more_note.first_container_note.insertAdjacentHTML('beforeend', ajax_loader({
							img_loc: '../images/svg_loader_width_160.svg',
							position: 'center'
						}));
					}
					break;

				case 'resend_otp':
					if (url_array('', 'forget_password')) {
						remove_ajax_loader();
						document.querySelector('.otp_form .resend_otp').insertAdjacentHTML('beforeend', ajax_loader({
							img_loc: '../images/6.svg',
							position: 'center'
						}, false));
					}
					break;

				case 'all_notes_title_wrap':
					if (window.location.href.search('user/topic') >= 0) {
						remove_ajax_loader();
						note_title.first_container_note.insertAdjacentHTML('beforeend', ajax_loader({
							img_loc: '../images/svg_loader_width_160.svg',
							position: 'center'
						}));
					}
					break;

				case 'all_watch_later_notes_wrap':
					if (window.location.href.search('user/watch_later') >= 0) {
						remove_ajax_loader();
						watch_later.first_container_note.insertAdjacentHTML('beforeend', ajax_loader({
							img_loc: '../images/svg_loader_width_160.svg',
							position: 'center'
						}));
					}
					break;

				case 'all_saved_imp_notes_wrap':
					if (window.location.href.search('user/important_notes') >= 0) {
						remove_ajax_loader();
						imp_note.first_container_note.insertAdjacentHTML('beforeend', ajax_loader({
							img_loc: '../images/svg_loader_width_160.svg',
							position: 'center'
						}));
					}
					break;

				case 'subjects_info_art':
					if (window.location.href.search('user/subjects') >= 0) {
						reset_loader_AJAX();
						subjects.first_container_note.insertAdjacentHTML('beforeend', '<div class="show_subjects_AJAX_loader_wrap">' + ajax_loader({
							img_loc: '../images/svg_loader_width_160.svg',
							position: 'center'
						}) + '</div>');
					}
					break;
				
				case 'change_profile_pic':
					document.querySelector('.profile button').innerHTML=`
					<img src="../images/6.svg" style="width:15px;height:15px;">`;
					break;
				default:
					// statements_def
					break;
			}
			return;
		}
		if (obj.e.target.classList.contains('login_btn')) {
			obj.e.target.textContent = 'Login...';
		} else if (obj.e.target.classList.contains('reg_btn')) {
			obj.e.target.textContent = 'Registering...';
		} else if (obj.e.target.classList.contains('save_note_btn')) {
			obj.e.target.textContent = 'Saving Note...';
			obj.e.target.classList.add('processsing_loader');
		} else if (obj.e.target.classList.contains('edit_note_btn')) {
			obj.e.target.textContent = 'Saving Note...';
			obj.e.target.classList.add('processsing_loader');
		} else if (obj.e.target.classList.contains('delete_btn_of_popup')) {
			obj.e.target.textContent = 'Deleting Note...';
		} else if (obj.e.target.classList.contains('subscription_form_btn')) {
			obj.e.target.classList.add('processsing_loader');
			obj.e.target.textContent = 'Please Wait...';
		}else if (obj.e.target.classList.contains('q_n_save_btn')) {
			obj.e.target.classList.add('processsing_loader');
			obj.e.target.textContent = 'Saving...';
		}else if (obj.e.target.classList.contains('message_to_developer_btn')) {
			obj.e.target.classList.add('processsing_loader');
			obj.e.target.textContent = 'Sending Message...';
		} else if (obj.e.target.classList.contains('award_to_deve_btn')) {
			obj.e.target.classList.add('processsing_loader');
			obj.e.target.textContent = 'Please Wait...';
		} else if (obj.e.target.classList.contains('email_send_btn')) {
			obj.e.target.classList.add('processsing_loader');
			obj.e.target.textContent = 'Please Wait...';
		} else if (obj.e.target.classList.contains('otp_send_btn')) {
			obj.e.target.classList.add('processsing_loader');
			obj.e.target.textContent = 'Please Wait...';
		} else if (obj.e.target.classList.contains('new_paswd_btn')) {
			obj.e.target.classList.add('processsing_loader');
			obj.e.target.textContent = 'Please Wait...';
		}
	}
	hide_loading(obj) {
		if (typeof obj.e === 'object') {
			obj.e.target.textContent = obj.default_btn_value['default_btn_value'];
			if (obj.e.target.classList.contains('subscription_form_btn')) {
				obj.e.target.classList.remove('processsing_loader');
			} else if (obj.e.target.classList.contains('message_to_developer_btn')) {
				obj.e.target.classList.remove('processsing_loader');
			}else if (obj.e.target.classList.contains('q_n_save_btn')) {
				obj.e.target.classList.remove('processsing_loader');
			} else if (obj.e.target.classList.contains('save_note_btn')) {
				obj.e.target.classList.remove('processsing_loader');
			}else if (obj.e.target.classList.contains('edit_note_btn')) {
				obj.e.target.classList.remove('processsing_loader');
			} else if (obj.e.target.classList.contains('award_to_deve_btn')) {
				obj.e.target.classList.remove('processsing_loader');
			} else if (obj.e.target.classList.contains('email_send_btn')) {
				obj.e.target.classList.remove('processsing_loader');
			} else if (obj.e.target.classList.contains('otp_send_btn')) {
				obj.e.target.classList.remove('processsing_loader');
			} else if (obj.e.target.classList.contains('new_paswd_btn')) {
				obj.e.target.classList.remove('processsing_loader');
			}
		} else if (typeof obj.e != 'object') {
			switch (obj.e) {
				case 'all_notes_art_wrap':
					if (window.location.href.search('user/notes') >= 0) {
						show_more_note.first_container_note.querySelectorAll('.ajax_loader1').forEach(element => {
							element.remove();
						});
					}
					break;

				case 'all_notes_title_wrap':
					if (window.location.href.search('user/topic') >= 0) {
						note_title.first_container_note.querySelectorAll('.ajax_loader1').forEach(element => {
							element.remove();
						});
					}
					break;

				case 'all_watch_later_notes_wrap':
					if (window.location.href.search('user/watch_later') >= 0) {
						watch_later.first_container_note.querySelectorAll('.ajax_loader1').forEach(element => {
							element.remove();
						});
					}
					break;

				case 'all_saved_imp_notes_wrap':
					if (window.location.href.search('user/important_notes') >= 0) {
						imp_note.first_container_note.querySelectorAll('.ajax_loader1').forEach(element => {
							element.remove();
						});
					}
					break;

				case 'subjects_info_art':
					if (window.location.href.search('user/subjects') >= 0) {
						reset_loader_AJAX();
					}
					break;
				
				case 'change_profile_pic':
					document.querySelector('.profile button').innerHTML='Save';
					break;

				case 'resend_otp':
					remove_ajax_loader();
					break;
				default:
					// statements_def
					break;
			}
		}
	}

	get_form_data(form_id) {
		let form_details = document.getElementById(form_id);
		if (form_details == null) return;
		let form_data = new FormData(form_details);
		switch (form_id) {
			case 'create_note_form':
				form_data.append('note_html', get_parsed_output.parsed_sanitized_markdown);
				break;
				
			case 'q_n_form':
				form_data.append('note_html', get_parsed_output.parsed_sanitized_markdown);
				if(document.querySelector('.q_n_note__id').value.trim() != ''){
					form_data.append('note_id', document.querySelector('.q_n_note__id').value.trim());
				}
				break;

			case 'edit_note_form':
				form_data.append('note_html', get_parsed_output.parsed_sanitized_markdown);
				break;

			default:
				// statements_def
				break;
		}
		let key, value;
		for ([key, value] of form_data.entries()) {
			console.log(key + ': '+ value);
		}
		return form_data;
	}
}

const reset_loader_AJAX = () => {
	let elements = subjects.first_container_note.querySelectorAll('.show_subjects_AJAX_loader_wrap');
	if (elements.length == 0) {
		return;
	}
	elements.forEach(element => {
		element.remove();
	});
}

class UserFormProcessAjax extends CommonAjaxFunctions {
	form_login_btn = document.querySelector('#login_form .login_btn');
	form_sinup_btn = document.querySelector('#reg_form .reg_btn');
	form_save_note = document.querySelector('#create_note_form .save_note_btn');
	form_edit_note = document.querySelector('#edit_note_form .edit_note_btn');
	form_subscription_email_btn = document.querySelector('#subsc_form .btn');
	request_in_progess = false;
	which_form = '';
	url;
	method;
	form_id;
	hide_loading_param = {};

	constructor() {
		super();
	}

	set_dynamic_object_for_loading_status() {
		switch (this.which_form) {
			case 'reg_form':
				this.hide_loading_param = {
					default_btn_value: 'Register'
				};
				break;
			case 'login_form':
				this.hide_loading_param = {
					default_btn_value: 'Login'
				};
				break;
			
			case 'create_quick_note_form':
				this.hide_loading_param = {
					default_btn_value: 'Save'
				};
				break;
				
			case 'save_note_form':
				this.hide_loading_param = {
					default_btn_value: 'Save Note'
				};
				break;
			case 'edit_note_form':
				this.hide_loading_param = {
					default_btn_value: 'Save Edited Note'
				};
				break;
			case 'delete_note_of_popup':
				this.hide_loading_param = {
					default_btn_value: 'Delete'
				};
				break;
			case 'subscription_form':
				this.hide_loading_param = {
					default_btn_value: "Subscribe"
				};
				break;
			case 'message_to_developer_form':
				this.hide_loading_param = {
					default_btn_value: 'Send Message'
				};
				break;
			case 'give_award_to_developer':
				this.hide_loading_param = {
					default_btn_value: 'Send'
				};
				break;
			case 'email_form':
				this.hide_loading_param = {
					default_btn_value: 'Send'
				};
				break;
			case 'otp_form':
				this.hide_loading_param = {
					default_btn_value: 'Submit'
				};
				break;
			case 'new_paswd_form':
				this.hide_loading_param = {
					default_btn_value: 'Submit'
				};
				break;
			case 'resend_otp':
				this.hide_loading_param = {
					default_btn_value: 'Resend OTP'
				};
			default:
				// statements_def
				break;
		}
	}

	reset_reg_form_err() {
		if (document.querySelector('#reg_art .error_div') != null) {
			document.querySelectorAll('#reg_art .error_div').forEach(element => {
				element.remove();
			});
		}
		if (document.querySelector('#reg_art .input_red_border') != null) {
			document.querySelectorAll('#reg_art .input_red_border').forEach(element => {
				element.classList.remove('input_red_border');
			});
		}
	}
	/* reset_reg_form_err()  -------ENDS*/

	reset_login_form_err() {
		if (document.querySelector('#login_art .error_div') != null) {
			document.querySelectorAll('#login_art .error_div').forEach(element => {
				element.remove();
			});
		}
		if (document.querySelector('#login_art .input_red_border') != null) {
			document.querySelectorAll('#login_art .input_red_border').forEach(element => {
				element.classList.remove('input_red_border');
			});
		}
	}
	/* reset_login_form_err()  -------ENDS*/

	show_reg_form_err(json) {
		this.reset_reg_form_err();
		let error_div = document.createElement('div');
		error_div.className = 'error_div';

		for (let i in json) {
			switch (i) {
				case 'username':
					error_div.textContent = json[i];
					document.querySelector('.reg_user_name_or_email').appendChild(error_div.cloneNode(true));
					document.getElementById('unique_username').classList.add('input_red_border');
					break;

				case 'password':
					error_div.textContent = json[i];
					document.querySelector('.reg_user_paswd').appendChild(error_div.cloneNode(true));
					document.getElementById('reg_user_paswd').classList.add('input_red_border');
					break;

				case 'confirm_password':
					error_div.textContent = json[i];
					document.querySelector('.reg_user_confirm_paswd').appendChild(error_div.cloneNode(true));
					document.getElementById('reg_user_confirm_paswd').classList.add('input_red_border');
					break;
				default:
					// statements_def
					break;
			}
		}
	}
	/* show_reg_form_err() -----ENDS*/

	show_login_form_err(json) {
		this.reset_login_form_err();
		let error_div = document.createElement('div');
		error_div.className = 'error_div';

		for (let i in json) {
			switch (i) {
				case 'username_email':
					error_div.textContent = json[i];
					document.querySelector('.user_name_or_email').appendChild(error_div.cloneNode(true));
					document.getElementById('unique_user_id').classList.add('input_red_border');
					break;

				case 'password':
					error_div.textContent = json[i];
					document.querySelector('.user_paswd_wrap').appendChild(error_div.cloneNode(true));
					document.getElementById('user_paswd').classList.add('input_red_border');
					break;

				case 'username_email_wrong':
					error_div.textContent = json[i];
					document.querySelector('.user_paswd').appendChild(error_div.cloneNode(true));
					break;
				default:
					// statements_def
					break;
			}
		}
	}

	/* show_login_form_error() -----ENDS*/


	set_dynamic_values(obj = {}) {
		if (typeof obj.e === 'object' && obj.e.target.hasAttribute("data-src")) {
			let data_src = obj.e.target.getAttribute('data-src');

			switch (data_src) {
				case 'reg_btn':
					this.form_id = obj.form_id;
					this.method = 'POST';
					if (window.location.href.search('/user/') >= 0 || get_url_file_name() == 'forget_password' || get_url_file_name() == 'about') {
						this.url = '../process/user_form_sinup.process.php';
					}else {
						this.url = './process/user_form_sinup.process.php';
					}
					this.which_form = obj.which_form;
					break;
				case 'login_btn':
					this.form_id = obj.form_id;
					this.method = 'POST';
					if (window.location.href.search('/user/') >= 0 || window.location.href.search('/pages/forget_password') >=0 || window.location.href.search('/pages/about') >=0) {
						this.url = '../process/user_form_login.process.php';
					} else {
						this.url = './process/user_form_login.process.php';
					}
					this.which_form = obj.which_form;
					break;
				case 'save_note_btn':
					this.form_id = obj.form_id;
					this.method = 'POST';
					this.url = './process/user_save_note.process.php';
					this.which_form = obj.which_form;
					break;

				case 'q_n_save_btn':
					this.form_id = obj.form_id;
					this.method = 'POST';
					this.url = './process/quick_note_save.process.php';
					this.which_form = obj.which_form;
					break;
				case 'email_send_btn':
					this.form_id = obj.form_id;
					this.method = 'POST';
					this.url = '../process/forget_password.process.php';
					this.which_form = obj.which_form;
					break;
				case 'otp_send_btn':
					this.form_id = obj.form_id;
					this.method = 'POST';
					this.url = '../process/forget_password.process.php';
					this.which_form = obj.which_form;
					break;
				case 'new_paswd_btn':
					this.form_id = obj.form_id;
					this.method = 'POST';
					this.url = '../process/forget_password.process.php';
					this.which_form = obj.which_form;
					break;

				case 'subscription_form_btn':
					this.form_id = obj.form_id;
					this.method = 'POST';
					this.url = './process/user_subscription.process.php';
					this.which_form = obj.which_form;
					break;

				case 'message_to_developer_btn':
					this.form_id = obj.form_id;
					this.method = 'POST';
					this.url = '../process/send_message_to_developer.process.php';
					this.which_form = obj.which_form;
					break;

				case 'edit_note_btn':
					this.form_id = obj.form_id;
					this.method = 'POST';
					this.url = './process/user_save_edited_note.process.php';
					this.which_form = obj.which_form;
					break;

				default:
					// statements_def
					break;
			} // switch()
			this.set_dynamic_object_for_loading_status();
		} else {
			switch (obj.which_form) {
				case 'load_user_notes':
					this.method = 'GET';
					this.url = './process/get_user_notes.process.php?page=' + (++show_more_note.page);
					this.which_form = obj.which_form;
					break;

				case 'load_user_notes_title':
					this.method = 'GET';
					this.url = './process/get_user_notes_title.process.php?page=' + (++note_title.page) + '&count=' + note_title.first_container_note.querySelectorAll('.sinlge_note_title').length;
					this.which_form = obj.which_form;
					break;

				case 'load_watch_later_notes':
					this.method = 'GET';
					this.url = './process/get_watch_later_notes.process.php?page=' + (++watch_later.page) + '&count=' + watch_later.first_container_note.querySelectorAll('.sinlge_note_title').length;
					this.which_form = obj.which_form;
					break;

				case 'load_saved_imp_notes':
					this.method = 'GET';
					this.url = './process/get_imp_notes.process.php?page=' + (++imp_note.page) + '&count=' + imp_note.first_container_note.querySelectorAll('.sinlge_note_title').length;
					this.which_form = obj.which_form;
					break;

				case 'load_user_subjects':
					this.method = 'GET';
					this.url = './process/get_user_subjects.process.php?page=' + (++subjects.page);
					this.which_form = obj.which_form;
					break;

				case 'load_user_subject_notes':
					this.method = 'GET';
					this.url = './process/get_user_subject_notes.process.php?page=' + (++subjects.page) + '&subject_name=' + obj['url_param'];
					this.which_form = obj.which_form;
					break;

				case 'increase_note_view_in_DB':
					this.method = 'GET';
					this.url = './process/increase_view_note.process.php?note_id=' + show_more_note.note_id;
					this.which_form = obj.which_form;
					break;

				case 'delete_note_of_popup':
					this.method = 'GET';
					this.url = './process/delete_note.process.php?note_id=' + show_more_note.note_id;
					this.which_form = obj.which_form;
					this.set_dynamic_object_for_loading_status();
					break;

				case 'resend_otp':
					this.method = 'GET';
					this.url = '../process/forget_password.process.php';
					this.which_form = obj.which_form;
					this.set_dynamic_object_for_loading_status();
					break;

				case 'watch_later':
					this.method = 'POST';
					this.url = './process/watch_later.process.php?note_id=' + watchLater.note_id;
					this.which_form = obj.which_form;
					// this.set_dynamic_object_for_loading_status();  
					break;

				case 'imp_notes':
					this.method = 'POST';
					this.url = './process/imp_note.process.php?note_id=' + saveNoteAsImportant.note_id;
					this.which_form = obj.which_form;
					// this.set_dynamic_object_for_loading_status();  
					break;

				case 'give_award_to_developer':
					this.method = 'GET';
					this.url = '../process/give_award_to_developer.process.php?award_id=' + award.current_trophy_ID;
					this.which_form = obj.which_form;
					this.set_dynamic_object_for_loading_status();
					break;

				case 'load_chart':
					this.method = 'GET';
					this.url = './process/get_charts_graphs.process.php';
					this.which_form = obj.which_form;
					break;
					

				case 'search_suggestion_subject_name':
					this.method = 'GET';
					this.url = './process/search_suggestion.process.php?suggestion_for=subject_name&input=' + obj['input'];
					this.which_form = obj.which_form;
					break;
				
				case 'change_profile_pic':
					this.method = 'GET';
					this.url = './process/change_profile_pic.process.php?selected_profile_pic=' + document.querySelector('input[name="s_profile"]:checked').closest('.profile').querySelector('img').src;
					this.which_form = obj.which_form;
					break;

				case 'search_suggestion_notes':
					this.method = 'GET';
					if (window.location.href.search('/user/') >= 0) {
						this.url = './process/search_suggestion.process.php?suggestion_for=notes&input=' + obj['input'];
						// check if key exists in object
						if ("access_for" in obj) {
							this.url += '&access_for=' + obj['access_for'];
						}
					} else {
						this.url = './user/process/search_suggestion.process.php?suggestion_for=notes&input=' + obj['input'];
						if ("access_for" in obj) {
							this.url += '&access_for=' + obj['access_for'];
						}
					}
					this.which_form = obj.which_form;
					break;


				default:
					// statements_def
					break;
			}
		}
	}

	/* params => e, has_form */
	call_of_ajax(obj = {}, multiple_request = 'false') {
		// Prevents multiple AJAX request.
		if (this.request_in_progess && multiple_request == 'false') {
			return;
		}
		this.request_in_progess = true;
		this.show_loading({
			e: obj.e
		});

		let xhr = new XMLHttpRequest();
		xhr.open(this.method, this.url, true);
		xhr.setRequestHeader('X-Requested-with', 'XMLHttpRequest');
		//--For POST request
		// Do not set content-type with FormData
		if (obj.has_form == false && this.method == 'POST') {
			xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
		}

		xhr.onreadystatechange = () => {
			try {
				console.log(xhr.readyState, xhr.status);
				if (xhr.readyState == 4 && xhr.status == 200) {
					this.hide_loading({
						e: obj.e,
						default_btn_value: this.hide_loading_param
					});
					console.log(xhr.responseText);
					let json = JSON.parse(xhr.responseText);
					if (json.hasOwnProperty('login') && json.login == 'false'){
						Swal.fire({
							icon: 'error',
							title: 'Error',
							html: '<p style="font-size:1.3em">Please login first</p>'
						  })
					}else if (json.hasOwnProperty('internet_connection') && json.internet_connection == false) {
						Toast.fire({
							html: `<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg">
							<g>
							 <title>background</title>
							 <rect fill="none" id="canvas_background" height="602" width="802" y="-1" x="-1"/>
							</g>
							<g>
							 <title>Layer 1</title>
							 <path id="svg_1" d="m16,14a2,2 0 1 0 0,4a2,2 0 1 0 0,-4zm5.657,-3.657c3.124,3.124 3.124,8.19 0,11.314m-11.314,0c-3.124,-3.124 -3.124,-8.19 0,-11.314m15.556,-4.242c5.467,5.467 5.467,14.332 0,19.799m-19.798,-0.001c-5.467,-5.467 -5.467,-14.332 0,-19.799" stroke-width="2" stroke-miterlimit="10" stroke="#000000" fill="none"/>
							 <path id="svg_2" d="m1.6255,4.10979l27.74903,24.74913" transform="rotate(-175.85482788085938 15.50001335144043,16.484359741210934) " stroke-linecap="null" stroke-linejoin="null" stroke-width="2" stroke="#ff0000" fill="#ffffff"/>
							</g>
						   </svg><br><br>
						   <div style="font-size:2em;color:red">You are not connected to the internet.</div>`
						});
					}else if(json.hasOwnProperty('form_error') && json.form_error == true){
						Swal.fire({
							icon: 'error',
							title: 'Form data error',
							html: '<div style="font-size:1.3em;text-align:left;"><div>The data you are trying to submit is not correct.</div><div>We give you hints on wrong data.So check them and resubmit the form.</div></div>',
						})
					}
					console.log(json);

					if (json.hasOwnProperty('type')) {
						switch (json.type) {
							case 'change_profile_pic':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									change_profile.updateUI();
									Swal.fire(
										'Profile Pic Updated Successfuly',
										'',
										'success'
									  );
								}else{
									Swal.fire(
										'Error',
										json['errors'],
										'error'
									  );
									
								}
								break;

							case 'load_charts_graphs':
								if (json.hasOwnProperty('result') && json.result == 'true') {
								graph_chart.show_pie_chart(
									{
										arr:json['data'],
										target_element:'#graph_ch',
										t_w_h:{'title':'Total Overview of notes','height':200}
								} // t_w_h = title_width_height
								);
							}else{
								document.getElementById('graph_ch').innerHTML = '<p class="no_graph">Please try to create note to see chart.</p>';
							}
							break;

							case 'user_reg':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									// [][][] show alert like PUBG (yellow) .
									// alert => may be data has been added successfuly.
									this.reset_reg_form_err();
									window.location.href = json['redirect_url'];
								} else if (json.hasOwnProperty('errors')) {
									this.show_reg_form_err(json.errors);
								}
								break;
							
							case 'quick_note':
								reset_by_class_name('quick_note_error');
								document.querySelector('.quick_note_section .wmd-input').style.boxShadow='';
								document.querySelector('.quick_note_section .wmd-preview').style.boxShadow='';
								document.querySelector('#q_n_paswd_input').style.border='1px inset rgb(183 183 183)';
								if(json.hasOwnProperty('result') && json.result == 'true'){
									if(get_url_file_name() != json['note_data']['note_id']){
										history.pushState({}, null, window.location.href.substr(0, window.location.href.lastIndexOf('/') + 1) + json['note_data']['note_id']);
										Swal.fire(
											json['message'],
											'',
											'success'
										);
										document.querySelector('.q_n_note__id').value = json['note_data']['note_id'];
									}else{
										Swal.fire(
											json['message'],
											'',
											'success'
										);
									}
									if(json['note_data']['is_admin'] == true){
										document.querySelector('.q_n_owner').innerHTML= 'You are ADMIN';
									}else{
										document.querySelector('.q_n_owner').innerHTML= '<strike>You are ADMIN</strike>';
									}
								}else{
									Swal.fire({
										icon: 'error',
										title: 'Error',
										html: '<div class="q_n_err_popup"><div>Your note has some errors.</div><div>.Please resolve those errros, then resubmit data. </div></div>' 
									  }).then((value) => {
									  	let err = '';
									  	for (let i in json['errors']) {
									  		// console.log(i, json['errors'][i]);
									  		switch(i){
									  			case 'note_markdown':
									  			document.querySelector('.quick_note_section .wmd-input').style.boxShadow='inset 0 0 0px 2px red';
									  			err = `<div class="quick_note_error"><ul>`;
									  			err += `<li>${json['errors'][i]}</li>`;
									  			err +='</ul></div>';
									  			document.querySelector('.quick_note_section .wmd-input').insertAdjacentHTML('afterend', err);
									  			break;

									  			case 'note_html':
									  			document.querySelector('.quick_note_section .wmd-preview').style.boxShadow='inset 0 0 0px 2px red';
									  			err = `<div class="quick_note_error"><ul>`;
									  			err += `<li>${json['errors'][i]}</li>`;
									  			err +='</ul></div>';
									  			document.querySelector('.quick_note_section .wmd-preview').insertAdjacentHTML('afterend', err);
									  			break;

									  			case 'note_id':
									  			err = `<div class="quick_note_error q_n_note_id_err">`;
									  			err += `${json['errors'][i]}`;
									  			err +='</div>';
									  			document.querySelector('.q_n_link .flex_same_line').insertAdjacentHTML('afterend', err);
									  			if(document.querySelector('.menu_icon.menu_active') == null){
									  				document.querySelector('.menu_icon').click();
									  			}
									  			break;

									  			case 'password':
									  			err = `<div class="quick_note_error q_n_note_id_err">`;
									  			err += `${json['errors'][i]}`;
									  			err +='</div>';
									  			document.querySelector('.paswd_no_mod').insertAdjacentHTML('beforebegin', err);
									  			if(document.querySelector('.menu_icon.menu_active') == null){
									  				document.querySelector('.menu_icon').click();
									  			}

									  			break;

									  			case 'password_for_update_note':
									  			if(!document.querySelector('.q_n_menu_wrap .menu_icon').classList.contains('menu_active')){
									  				document.querySelector('.q_n_menu_wrap .q_n_m_content').classList.add('show_q_n_content');
									  				document.querySelector('.q_n_menu_wrap .menu_icon').classList.add('menu_active');
									  			}
									  			document.querySelector('.q_n_menu_wrap #q_n_private').checked = false;
									  			document.querySelector('.q_n_menu_wrap #q_n_paswd_checkbox').checked = true;
									  			document.querySelector('.q_n_menu_wrap .q_n_paswd').style.display='block';
									  			document.querySelector('.q_n_menu_wrap .q_n_editable').style.display='block';
									  			document.querySelector('.q_n_menu_wrap #q_n_paswd_input').style.display='inline-block';
									  			document.querySelector('.q_n_menu_wrap #q_n_paswd_input').style.border="2px inset red";
									  			err = `<div class="quick_note_error quick_note_err_mod1"><ul>`;
									  			err += `<li>${json['errors'][i]}</li>`;
									  			err +='</ul></div>';
									  			document.querySelector('.q_n_menu_wrap .q_n_paswd').insertAdjacentHTML('beforeend', err);
									  			break;
									  		}
									  	}							  
										});
								}
							break;
							case 'user_login':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									this.reset_login_form_err();
									window.location.href = json['redirect_url'];
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									this.show_login_form_err(json.errors);
								}
								break;

							case 'get_user_notes':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									if (show_more_note.page == 1) {
										document.querySelector('.head_prev_notes_wrap').insertAdjacentHTML('afterend', json.top_nav);
										navBar.add_event_short_navBar();
									}
									show_more_note.first_container_note.insertAdjacentHTML('beforeend', json.user_notes_html);
									show_more_note.addEventListener_on_showMore();
									show_more_note.addEventListener_on_delete();
									watchLater.add_event_list_on_watchLaterButton();
									saveNoteAsImportant.add_event_list_on_impButton();

								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									show_more_note.first_container_note.insertAdjacentHTML('beforeend', json.error);
								} else if (json.hasOwnProperty('message')) {
									// This code block will execute only when no note is left to show.
									// Must give null when no more note is left to show.
									show_more_note.page = null;
									show_more_note.first_container_note.insertAdjacentHTML('beforeend', show_more_note.no_more_note(json.message));
								}
								break;

							case 'get_user_notes_title':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									if (note_title.page == 1) {
										document.querySelector('.notes_title_wrap_sec').insertAdjacentHTML('afterbegin', json.top_nav);
										navBar.add_event_short_navBar();
									}
									note_title.first_container_note.insertAdjacentHTML('beforeend', json.user_notes_html);
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									note_title.first_container_note.insertAdjacentHTML('beforeend', json.error);
								} else if (json.hasOwnProperty('message')) {
									// This code block will execute only when no note is left to show.
									// Must give null when no more note is left to show.
									note_title.page = null;
									note_title.first_container_note.insertAdjacentHTML('beforeend', note_title.no_more_note(json.message));
								}
								break;

							case 'get_watch_later_notes_title':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									if (watch_later.page == 1) {
										document.querySelector('.notes_title_wrap_sec').insertAdjacentHTML('afterbegin', json.top_nav);
										navBar.add_event_short_navBar();
									}
									watch_later.first_container_note.insertAdjacentHTML('beforeend', json.user_notes_html);
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									watch_later.first_container_note.insertAdjacentHTML('beforeend', json.error);
								} else if (json.hasOwnProperty('message')) {
									// This code block will execute only when no note is left to show.
									// Must give null when no more note is left to show.
									watch_later.page = null;
									watch_later.first_container_note.insertAdjacentHTML('beforeend', watch_later.no_more_note(json.message));
								}
								break;

							case 'get_imp_notes_title':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									if (imp_note.page == 1) {
										document.querySelector('.notes_title_wrap_sec').insertAdjacentHTML('afterbegin', json.top_nav);
										navBar.add_event_short_navBar();
									}
									imp_note.first_container_note.insertAdjacentHTML('beforeend', json.user_notes_html);
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									imp_note.first_container_note.insertAdjacentHTML('beforeend', json.error);
								} else if (json.hasOwnProperty('message')) {
									// This code block will execute only when no note is left to show.
									// Must give null when no more note is left to show.
									imp_note.page = null;
									imp_note.first_container_note.insertAdjacentHTML('beforeend', imp_note.no_more_note(json.message));
								}
								break;

							case 'get_user_subjects':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									if (subjects.page == 1) {
										document.querySelector('.head_notes_title_wrap').insertAdjacentHTML('afterend', json.top_nav);
										navBar.add_event_short_navBar();

										subjects.first_container_note.insertAdjacentHTML('beforeend', '<section id="subject_tiles_wrap">' + json.user_subject_html + '</section>');

									} else {
										subjects.subject_tiles_wrap = document.querySelector('.subjects_info_art #subject_tiles_wrap');
										subjects.subject_tiles_wrap.insertAdjacentHTML('beforeend', json.user_subject_html);
									}
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									subjects.first_container_note.insertAdjacentHTML('beforeend', json.error);
								} else if (json.hasOwnProperty('message')) {
									// This code block will execute only when no note is left to show.
									// Must give null when no more note is left to show.
									subjects.page = null;
									subjects.first_container_note.insertAdjacentHTML('beforeend', subjects.no_more_note(json.message));
								}
								break;

							case 'get_user_subject_notes':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									if (json.hasOwnProperty('subject_notes_info')) {
										subjects.first_container_note.insertAdjacentHTML('beforeend', json.subject_notes_info);
									}
									subjects.first_container_note.insertAdjacentHTML('beforeend', json.user_subject_notes_html);
									show_more_note.addEventListener_on_showMore();
									show_more_note.addEventListener_on_delete();
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									subjects.first_container_note.insertAdjacentHTML('beforeend', json.error);
								} else if (json.hasOwnProperty('message')) {
									// This code block will execute only when no note is left to show.
									// Must give null when no more note is left to show.
									subjects.page = null;
									subjects.first_container_note.insertAdjacentHTML('beforeend', subjects.no_more_note(json.message));
								} else if (json.hasOwnProperty('server_error') && json.server_error == 'true') {
									subjects.page = null;
									subjects.first_container_note.insertAdjacentHTML('beforeend', server_error_msg_AJAX(json.error));
								}
								break;

							case 'create_note':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									reset_by_class_name('form_errors');
									save_note.show_success_alert(json);
									save_note.addEventListener_on_alert();
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									reset_by_class_name('form_errors');
									show_save_note_form_data_errors(json);
									// save_note.show_error_alert(json.errors);
									// save_note.addEventListener_on_alert();

								}
								break;

							case 'edit_note':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									reset_by_class_name('form_errors');
									edit_note.show_success_alert();
									edit_note.addEventListener_on_alert();
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									reset_by_class_name('form_errors');
									show_save_note_form_data_errors(json);
									//edit_note.show_error_alert(json.errors);
									//edit_note.addEventListener_on_alert();
								}
								break;

							case 'watch_later':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									show_alert_like_PUBG.show_action_message('<div class="tt">' + json.message + '</div>', document.body);
									watchLater.update_image_watch_later(json);
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									show_alert_like_PUBG.show_message('<div class="tt">' + json.errors + '</div>', document.body);
								}
								break;

							case 'user_subscription':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									reset_by_class_name('error_msg');
									reset_by_class_name('success_msg');
									document.querySelector('.input_span_psuedo').insertAdjacentHTML('afterend', '<div class="success_msg"><span class="center-flex"><div class="error_deep_child"><span class="material-icons">done</span>' + json.message + '</div></span></div>');
								} else if (json.hasOwnProperty('errors') && !json.hasOwnProperty('error_type') && json.result == 'false') {
									reset_by_class_name('error_msg');
									reset_by_class_name('success_msg');
									document.querySelector('.input_span_psuedo').insertAdjacentHTML('afterend', '<div class="error_msg"><span class="center-flex"><div class="error_deep_child"><span class="material-icons">error</span>' + json.errors.email + '</div></span></div>');
								}
								break;

							case 'send_award_to_dev':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									reset_by_class_name('error_msg');
									reset_by_class_name('success_msg');
									document.querySelector('.award_send_btn_wrap').insertAdjacentHTML('beforebegin', '<div class="success_msg"><span class="center-flex"><div class="error_deep_child"><span class="material-icons">done</span>' + json.message + '</div></span></div>');
								} else if (json.hasOwnProperty('errors') && !json.hasOwnProperty('error_type') && json.result == 'false') {
									reset_by_class_name('error_msg');
									reset_by_class_name('success_msg');
									document.querySelector('.award_send_btn_wrap').insertAdjacentHTML('beforebegin', '<div class="error_msg"><span class="center-flex"><div class="error_deep_child"><span class="material-icons">error</span>' + json.errors + '</div></span></div>');
								}
								break;

							case 'message_to_developer':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									reset_by_class_name('error_msg');
									reset_by_class_name('success_msg');
									document.querySelector('.msg_me_wrap .textarea').insertAdjacentHTML('afterend', '<div class="success_msg"><span class="center-flex"><div class="error_deep_child"><span class="material-icons">done</span>' + json.message + '</div></span></div>');
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									reset_by_class_name('error_msg');
									reset_by_class_name('success_msg');

									let errors_temp = '';
									for (let i in json.errors) {
										errors_temp += `<div class="error_deep_child"><span class="material-icons">error</span>${json.errors[i]}</span></div>`;
									}
									document.querySelector('.msg_me_wrap .textarea').insertAdjacentHTML('afterend', '<div class="error_msg"><span class="center-flex">' + errors_temp + '</span></div>');
								}
								break;

							case 'imp_note':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									show_alert_like_PUBG.show_action_message('<div class="tt">' + json.message + '</div>', document.body);
									saveNoteAsImportant.update_image_imp_note(json);
								} else if (json.hasOwnProperty('errors') && json.result == 'false') {
									show_alert_like_PUBG.show_message('<div class="tt">' + json.errors + '</div>', document.body);
								}
								break;

							case 'delete_note':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									//show_alert_msg_ajax({msg:json['message'], id: 'ajax_success_message', hide_time: 8000, auto_hide:true});
									show_alert_like_PUBG.show_message('<div class="tt">' + json.message + '</div>', document.body);
									// automatically hide the poppuped alert
									show_more_note.close_btn_function(document.getElementById('show_note_popup'));
									show_more_note.remove_deleted_element();

								} else if (json.hasOwnProperty('popup_error') && json.popup_error == 'true') {
									show_more_note.close_btn_function(document.getElementById('show_note_popup'));
									// Give `id= ajax_success_message` for success msg
									Swal.fire({
										icon: 'error',
										title: 'Error',
										html: json['errors']
									  });
								}
								break;

							case 'search_suggestion_subject':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									search_suggestion.show_suggestion_for_subject_name(json['html_data']);
								} else {
									search_suggestion.reset_suggestion('subject_suggestion');

								}
								break;

							case 'search_suggestion_notes':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									search_suggestion.show_suggestion_for_notes(json['html_data']);
								} else {
									search_suggestion.reset_suggestion('search_sugg_notes');
								}
								break;

							case 'user_changning_paswd':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									forget_password.show_otp_form(json);
								} else {
									reset_by_class_name('error_msg');
									reset_by_class_name('success_msg');
									remove_class_name('.email_form #email', 'input_border_red');
									document.querySelector('.email_form #email').classList.add('input_border_red');

									let errors_temp = '';
									for (let i in json.errors) {
										errors_temp += `<div class="error_deep_child"><span class="material-icons">error</span>${json.errors[i]}</span></div>`;
									}
									document.querySelector('.email_form .input_email_div').insertAdjacentHTML('beforeend', '<div class="error_msg"><span class="center-flex">' + errors_temp + '</span></div>');
								}
								break;

								//when user submit OTP in action of changning password.
							case 'user_otp_for_changning_paswd':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									forget_password.show_new_paswd_form(json);
								} else {
									reset_by_class_name('error_msg');
									reset_by_class_name('success_msg');
									remove_class_name('.otp_form #otp', 'input_border_red');
									document.querySelector('.otp_form #otp').classList.add('input_border_red');

									let errors_temp = '';
									for (let i in json.errors) {
										errors_temp += `<div class="error_deep_child"><span class="material-icons">error</span>${json.errors[i]}</span></div>`;
									}
									document.querySelector('.otp_form .input_otp_div').insertAdjacentHTML('beforeend', '<div class="error_msg"><span class="center-flex">' + errors_temp + '</span></div>');
								}
								break;

								//when user has try to change the password.
							case 'user_account_paswd_change':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									forget_password.show_success_message(json);
								} else {
									reset_by_class_name('error_msg');
									reset_by_class_name('success_msg');
									// remove_class_name('.otp_form #otp', 'input_border_red');
									// document.querySelector('.otp_form #otp').classList.add('input_border_red');

									let errors_temp = '';
									for (let i in json.errors) {
										errors_temp += `<div class="error_deep_child"><span class="material-icons">error</span>${json.errors[i]}</span></div>`;
									}
									document.querySelector('.confirm_input_paswd_div').insertAdjacentHTML('beforeend', '<div class="error_msg"><span class="center-flex">' + errors_temp + '</span></div>');
								}
								break;

							case 'user_resend_otp_for_changning_paswd':
								if (json.hasOwnProperty('result') && json.result == 'true') {
									forget_password.show_resent_otp_message(json);
								} else {
									/**
									 * TODO
									 * *
									 * *
									 * *
									 */

								}
								break;
							default:
								// statements_def
								break;
						}

					}

				} else if (xhr.readyState == 4 && xhr.status == 404) {
					// code for handle errors...
					// [][][] show alert like PUBG (yellow) .
					// alert => may be like something went wrong.
					console.log(`ERROR : script for processing not found. (${xhr.status})`);
					// (has_form == true)  ? hide_loading(e) : hide_loading_specific(e);

				}
				// It means request has completed.
				this.request_in_progess = false;
			} catch (e) {
				// [][][] show alert like PUBG (yellow) .
				console.log('%c ERROR : ' + e, 'color: red;');
			} finally {
				/*	    if(xhr.readyState == 4){
							if(document.querySelector('.temp_loading')){
								let second_loading = document.querySelectorAll('.temp_loading');
								for (let k = 0; k < second_loading.length; k++) {
									second_loading[k].remove();
								}
							    
							}
						}*/
			}


		}; // onreadystatechange()
		/* Sending the request */
		if (obj.has_form == true) {
			xhr.send(this.get_form_data(this.form_id));
		} else {
			xhr.send();
		}
	}
}



/* show hide Sinup/Login form --STARTS*/

let form_control = new UserFormAccess;
if (form_control.signup_btn != null) {
	form_control.signup_btn.addEventListener('click', e => {
		form_control.show_signup_form();
	}, false);
}

if (form_control.signin_btn != null) {
	form_control.signin_btn.addEventListener('click', e => {
		form_control.show_login_form();
	}, false);
}

if (form_control.login_close_btn != null) {
	form_control.login_close_btn.addEventListener('click', () => {
		form_control.hide_login_form();
	}, false);
}

if (form_control.signup_close_btn != null) {
	form_control.signup_close_btn.addEventListener('click', () => {
		form_control.hide_signup_form();
	}, false);
}

if (form_control.back_to_signup != null) {
	form_control.back_to_signup.addEventListener('click', () => {
		form_control.show_signup_form();
	}, false);
}

if (form_control.back_to_login != null) {
	form_control.back_to_login.addEventListener('click', () => {
		form_control.show_login_form();
	}, false);
}

let paswd_input = document.querySelectorAll('.only_word_char_input');
if(paswd_input.length > 0){
		let result;
		paswd_input.forEach((element) => {
		  element.addEventListener('input', (e) => {
		  	result = String(filter_by_regex(e.target.value));
		  	e.target.value = result != 'null' ? result : '';
		  });
		});
	}
/* show hide Sinup/Login form -----------ENDS*/

/* Sinup/Login form process --STARTS*/
let ajax_form_process = new UserFormProcessAjax;
if (ajax_form_process.form_login_btn != null) {
	ajax_form_process.form_login_btn.addEventListener('click', e => {
		e.preventDefault();
		ajax_form_process.set_dynamic_values({
			e: e,
			form_id: 'login_form',
			which_form: 'login_form'
		});
		ajax_form_process.call_of_ajax({
			e: e,
			has_form: true
		});
	}, false);
}

if (ajax_form_process.form_sinup_btn != null) {
	ajax_form_process.form_sinup_btn.addEventListener('click', e => {
		e.preventDefault();
		ajax_form_process.set_dynamic_values({
			e: e,
			form_id: 'reg_form',
			which_form: 'reg_form'
		});
		ajax_form_process.call_of_ajax({
			e: e,
			has_form: true
		});
	}, false);
}
/* Sinup/Login form process -----------ENDS*/

/* save note process --STARTS*/
/*if(window.location.href.substr(-15) == 'create_note.php'){
	console.log('running md parsed...');
	var converter = new showdown.Converter();
	text      = '`hello`, markdown!';
	html      = converter.makeHtml(text);
	console.log(html);
}*/

class ChangeProfilePic
{
	selected_pic_div = '';
	add_event_on_button(){
		document.querySelector('.profile button').addEventListener('click',(e)=>{
			e.preventDefault();
			if(document.querySelector('input[name="s_profile"]:checked') != null){
				this.send_request();
				this.selected_pic_div = document.querySelector('input[name="s_profile"]:checked').closest('.profile');
			}
		});
	}

	updateUI(){
		let previous_profile_pic_url = document.querySelector('.current_profile img').src;
		// moving selected [right/left] src to middle src.
		document.querySelector('.current_profile img').src = this.selected_pic_div.querySelector('img').src.replace('s=80', 's=60');
		// moving middle src to selected [right/left] src.
		this.selected_pic_div.querySelector('img').src = previous_profile_pic_url.replace('s=60', 's=80');
		// updating main user profile which is 130px.
		document.querySelector('.current_user_profile img').src = document.querySelector('.current_profile img').src.replace('s=60', 's=130');
	}

	send_request(){
		ajax_call(
			{
				d_values :{
					e: '',
					form_id: '',
					which_form: 'change_profile_pic'
				},
				xhr_values: {
					e: 'change_profile_pic',
					has_form: false
				},
				multiple_request : 'false'
			}
		);
	}
}

if(url_array('', 'profile','user')){
	var change_profile = new ChangeProfilePic;
	change_profile.add_event_on_button();
}

class ChartsGraphs
{
	send_request(){
		ajax_call(
			{
				d_values :{
					e: '',
					form_id: '',
					which_form: 'load_chart'
				},
				xhr_values: {
					e: 'load_charts_graphs',
					has_form: false
				},
				multiple_request : 'true'
			}
		);
	}
	// {arr:json, target_element:insert_into, t_w_h:{title, width, height}}
	show_pie_chart(obj={}){
		// load google charts
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);

		// Draw the chart and set the chart values
		function drawChart() {
			var data = google.visualization.arrayToDataTable(obj.arr);

			// Optional; add a title and set the width and height of the chart
			var options = obj.t_w_h;

			// Display the chart inside the <div> element with id="piechart"
			var chart = new google.visualization.PieChart(document.querySelector(obj.target_element));
			chart.draw(data, options);
		}
		
	}
}

if(window.location.href.search('/user/overview') > 0){
	var graph_chart = new ChartsGraphs;
	setTimeout(() => {
		graph_chart.send_request();
	}, 0);
	console.log('google chart will show');
}else{
	console.log('google chart will NOT show');
}

if(document.querySelector('.split_view_wrap .s_v_box')){
	let split_div = document.querySelector('.quick_note_section .s_v_box');
	let divider = document.querySelector('.quick_note_section .s_v_divider');
	let split_div_wrap = document.querySelector('.row1_item.item2');
	let textarea = document.querySelector('.quick_note_section .wmd-input');
	if(split_div != null){
		split_div.addEventListener('click', (e)=>{
			if(e.target.children[0].classList.contains('s_v_divider_vert')){
				e.target.children[0].classList.remove('s_v_divider_vert');
				split_div_wrap.classList.remove('split_vert');
				split_div_wrap.querySelector('#wmd-preview').classList.remove('q_n_min_shadow');
			}else{
				e.target.children[0].classList.add('s_v_divider_vert');
				split_div_wrap.classList.add('split_vert');
				split_div_wrap.querySelector('#wmd-preview').classList.add('q_n_min_shadow');
			}
		});
	}
	if(textarea != null){
		// fetching previous saved note content from the user browser.
		if(localStorage.quick_note_content && textarea.value == ''){
			textarea.value = localStorage.quick_note_content;
		}
		// saving note content to the user browser.
		textarea.addEventListener('input', (e)=>{
			localStorage.quick_note_content = textarea.value;
		});
	}

}

// s_v_box

class ForgetPassword {
	email_btn = document.querySelector('.email_form .email_send_btn');
	// otp_btn = document.querySelector('.otp_form .otp_send_btn');
	// new_paswd_btn = document.querySelector('.new_paswd_form .new_paswd_btn');

	add_click_eve_on_email_btn() {
		if (this.email_btn == null) {
			return false;
		}
		this.email_btn.addEventListener('click', (e) => {
			e.preventDefault();
			//document.querySelector('.email_form #email').focus();

			if (document.querySelector('.write_email #email').value.trim() == '') {
				shake_element('.email_form .email_input_f_p');
				return false;
			}
			ajax_form_process.set_dynamic_values({
				e: e,
				form_id: 'email_form',
				which_form: 'email_form'
			});
			ajax_form_process.call_of_ajax({
				e: e,
				has_form: true
			});
		}, false);
	}

	add_click_eve_on_otp_btn() {
		let otp_btn = document.querySelector('.otp_form .otp_send_btn');
		if (otp_btn == null) {
			return false;
		}
		otp_btn.addEventListener('click', (e) => {
			e.preventDefault();
			if (document.querySelector('.write_otp #otp').value.trim() == '') {
				shake_element('.otp_form #otp');
				return false;
			}
			ajax_form_process.set_dynamic_values({
				e: e,
				form_id: 'otp_form',
				which_form: 'otp_form'
			});
			ajax_form_process.call_of_ajax({
				e: e,
				has_form: true
			});
		}, false);
	}
	add_click_eve_on_paswd_btn() {
		let paswd_btn = document.querySelector('.new_paswd_form .new_paswd_btn');
		if (paswd_btn == null) {
			return false;
		}

		paswd_btn.addEventListener('click', (e) => {
			e.preventDefault();
			ajax_form_process.set_dynamic_values({
				e: e,
				form_id: 'new_paswd_form',
				which_form: 'new_paswd_form'
			});
			ajax_form_process.call_of_ajax({
				e: e,
				has_form: true
			});
		}, false);
	}



	show_success_message(json) {
		reset_by_class_name('error_msg');
		reset_by_class_name('success_msg');
		//remove_class_name('.email_form #email', 'input_border_red');
		anime({
			targets: '.main_f_p .write_new_paswd',
			translateY: -250,
			scale: 0,
			easing: 'linear',
			opacity: [1, 0],
			duration: 800
		});
		setTimeout(() => {
			document.querySelector('.write_new_paswd').remove();
		}, 1000);

		setTimeout(() => {
			// show popup by sweetAlert library.
			Swal.fire(
				json['message'],
				'Now you can login by your new password.',
				'success'
			).then((result) => {
				window.location = json['redirect_to'];
			});
		}, 500);
	}

	show_otp_form(json) {
		reset_by_class_name('error_msg');
		reset_by_class_name('success_msg');
		remove_class_name('.email_form #email', 'input_border_red');
		anime({
			targets: '.main_f_p .write_email',
			translateY: -250,
			scale: 0,
			easing: 'linear',
			opacity: [1, 0],
			duration: 800
		});
		setTimeout(() => {
			document.querySelector('.write_email').remove();
		}, 1000);

		setTimeout(() => {
			document.querySelector('.main_f_p .forget_password_header').insertAdjacentHTML('afterend', json['otp_form']);
			anime({
				targets: '.main_f_p .write_otp',
				translateY: [250, 0],
				scale: [1.5, 1],
				duration: 1000
			});
			this.add_click_eve_on_otp_btn();
			this.add_click_eve_on_resendOTP_btn();
			document.querySelector('.forget_password_header .material-icons').textContent = 'keyboard';
			document.querySelector('.otp_form #otp').focus();
		}, 800);
	}

	show_new_paswd_form(json) {
		reset_by_class_name('error_msg');
		reset_by_class_name('success_msg');
		remove_class_name('.email_form #email', 'input_border_red');
		anime({
			targets: '.main_f_p .write_otp',
			translateY: -250,
			scale: 0,
			easing: 'linear',
			opacity: [1, 0],
			duration: 800,
			custom_f: setTimeout(() => {
				document.querySelector('.write_otp').remove();
			}, 1000)
		});

		setTimeout(() => {
			document.querySelector('.main_f_p .forget_password_header').insertAdjacentHTML('afterend', json['new_paswd_form']);
			anime({
				targets: '.main_f_p .write_new_paswd',
				translateY: [250, 0],
				scale: [1.5, 1],
				duration: 1000
			});
			this.add_click_eve_on_paswd_btn();
			document.querySelector('.forget_password_header .material-icons').textContent = 'enhanced_encryption';
			document.querySelector('.new_paswd_form #new_paswd').focus();
		}, 800);
	}

	add_click_eve_on_resendOTP_btn() {
		let resend_otp_btn = document.querySelector('.otp_form .resend_otp');
		if (resend_otp_btn == null) {
			return false;
		}

		resend_otp_btn.addEventListener('click', (e) => {
			ajax_form_process.set_dynamic_values({
				e: '',
				form_id: '',
				which_form: 'resend_otp'
			});
			console.log(ajax_form_process);
			ajax_form_process.call_of_ajax({
				e: 'resend_otp',
				has_form: false
			});
		}, false);
	}

	show_resent_otp_message(json) {
		reset_by_class_name('main_f_p .otp_form .sucess_otp_wrap');
		let html = `<div class="sucess_otp_wrap center_form">
    		<div class="success_otp">
	    		<span class="material-icons green md-36 el">check</span>
	    		<span class="message el">${json['message']}</span>
	    		<span class="material-icons red-button close_btn el">close</span>
    		</div>
    		</div>`;
		document.querySelector('.otp_form .input-info').insertAdjacentHTML('afterend', html);

		anime({
			targets: '.otp_form .sucess_otp_wrap',
			scale: [0.5, 1],
			opacity: [0, 1],
			translateY: [-100, 0],
			easing: 'easeInOutExpo',
		});


		// adding click event on close btn on message.
		add_close_action_event({
			close_btn: '.sucess_otp_wrap .close_btn',
			element_to_remove: '.main_f_p .sucess_otp_wrap'
		});
	}

}

if (url_array('', 'forget_password')) {
	var forget_password = new ForgetPassword;
	forget_password.add_click_eve_on_email_btn();
}



class createTag {
	tag_input = document.getElementById('new_note_tag');
	preview_tags_wrap = document.querySelector('.preview_all_tags');
	close_event_added = false;
	unique_tags_array = [];
	constructor() {
		this.seperator = ',';
		if(this.preview_tags_wrap != null && this.close_event_added == false){
			this.add_click_eve_on_close_btn();
		}
	}
	reset_preview_tags() {
		document.querySelector('.preview_all_tags').textContent = '';
	}
	add_click_eve_on_close_btn(){
		let preview_tags_wrap = document.querySelector('.preview_all_tags');
		preview_tags_wrap.addEventListener('click', (e) => {
			if(e.target.classList.contains('p_tag_close_btn')){
				this.remove_tag(e.target.parentElement.children[0].textContent);
				this.update_input_tag();
				e.target.parentElement.style.animation = 'bi_dir_width 1s cubic-bezier(0.38, 0.15, 0.15, 1.2)';
				setTimeout(() => {
					e.target.parentElement.remove();
				}, 980);
			}
		});
		this.close_event_added = true;
	}
	
	remove_tag(tag_name){
		 this.unique_tags_array.splice(this.unique_tags_array.indexOf(tag_name) , 1);

	}
	update_input_tag(){
		document.getElementById('new_note_tag').value = this.unique_tags_array.join(',');
	}

	extract_tags() {
		let tags_array_dup_data = this.tag_input.value.split(this.seperator);
		//removing empty elements.
		if(tags_array_dup_data.length > 1){
			let tags_array_remove_em = tags_array_dup_data.filter(Boolean);
			// removing duplicate tags from array.
			this.unique_tags_array = get_unique_array(tags_array_remove_em);
			if(!compare_arrays(tags_array_remove_em, this.unique_tags_array)){
				if(tags_array_dup_data[tags_array_dup_data.length - 1].trim() == ''){
					this.tag_input.value = tags_array_remove_em.join(',') + ',';
				}else{
					this.tag_input.value = tags_array_remove_em.join(',');
				}
			}
		}else{
			this.unique_tags_array = tags_array_dup_data;
		}
		
		let parent_tags_div = document.querySelector('.preview_all_tags');
		let preview_html = '';
		let filtered_html = '';
		this.reset_preview_tags();
		
		this.unique_tags_array.forEach((element, index) => {
			if (element.trim().length < 1) {
				return;
			}
			filtered_html = strip_html(element);
			preview_html = `
                <div class="p_tags">
                <span class="p_tag_info">${filtered_html}</span>
                <span class="p_tag_close_btn p_tag_close_btn_${index}">x</span>
                </div>
                `;
			// parent_tags_div.innerHTML = preview_html; 
			parent_tags_div.insertAdjacentHTML('beforeend', preview_html);
		});

		// adding click event on close tag btn
		if(this.close_event_added == false){
			this.add_click_eve_on_close_btn();
		}
	}
} // class createTag{}



class award_to_developer {
	current_trophy_ID = null;
	add_event_on_btn() {
		let btn = document.querySelector('.award_me_art .btn');
		if (btn != null) {
			btn.addEventListener('click', (e) => {
				if (this.current_trophy_ID == null) {
					anime({
						targets: '.award_me_art .child_award',
						scale: [2,0,1,2,0,1],
						rotate:[45,-45,0],
						easing: 'linear',
						duration: 1000
					});
					return;
				}
				ajax_form_process.set_dynamic_values({
					e: '',
					form_id: '',
					which_form: 'give_award_to_developer'
				});
				ajax_form_process.call_of_ajax({
					e: e,
					has_form: false
				});
			}, false);
		}
	}

	give_me_award() {
		let container = document.querySelector('.award_me_art');
		let previous_clicked_trophy = null;
		let trophy_name = '';
		let create_element_id = 0;
		if (container == null) {
			return;
		}
		container.addEventListener('click', (e) => {
			if (e.target.classList.contains('child_award')) {
				if (previous_clicked_trophy != null) {
					anime({
						targets: '.award_me_wrap .' + trophy_name,
						scale: [1.5, 1],
						duration: 300
					});
				}
				previous_clicked_trophy = e.target.getAttribute('data-trophy-id');
				this.current_trophy_ID = previous_clicked_trophy;
				if (previous_clicked_trophy == 0) {
					trophy_name = 'gold-trophy';
				} else if (previous_clicked_trophy == 1) {
					trophy_name = 'silver-trophy';
				} else {
					trophy_name = 'bronze-trophy';
				}

				//used for sending ajax request to save user response in DB.
				this.current_clicked_trophy = document.querySelector('.award_me_wrap .' + trophy_name);

				anime({
					targets: this.current_clicked_trophy,
					scale: [1, 1.5],
					duration: 300
				});
			}
		}, false);
	}
}

let award = new award_to_developer;
award.add_event_on_btn();
award.give_me_award();



class saveNote {
	save_note_btn = document.querySelector('.save_note_btn');
	success_alert_box(json) {
		let s_a_box = `
<div class="show_confirmation_full_wrap">
	<div class="edited_note_confirmation_user_box_wrap">
		<div class="confirmation_box_header_wrap">
			<span class="confirmation_header_info">Message</span>
			<span class="confirmation_close_btn">X</span>
		</div><!-- .confirmation_box_header_wrap  -->

		<div class="confirmation_header_body_wrap">
			<div class="confirmation_data_wrap">
				<h3>Your note has saved successfully !</h3>
				<div class="check_img_wrap"><img src="../images/check.svg" class="check"></div>
				<div class="action_info__alert_wrap">
					<div class="create_new_note_wrap">
						<button>Create new Note</button>
					</div>
					<div class="edit_saved_note_wrap">
						<a href="./edit_note?noteID=${json.note_id}"><button>Edit this note</button></a>
					</div>
					<div class="go_back_to_note_wrap">
						<a href="./notes"><button>Go back to your notes</button></a>
					</div>
				</div>
			</div> <!-- .confirmation_data_wrap  -->
		</div><!-- .confirmation_header_body_wrap  -->
	</div><!-- .edited_note_confirmation_user_box_wrap  -->
</div><!-- .show_confirmation_full_wrap  -->
`;
		return s_a_box;
	}
	error_alert_box(error_message) {
		let s_a_box = `
        	        <div class="show_confirmation_full_wrap">
        	            <div class="edited_note_confirmation_user_box_wrap">
        	                <div class="confirmation_box_header_wrap">
        	                    <span class="confirmation_header_info">Message</span>
        	                    <span class="confirmation_close_btn">X</span>
        	                </div><!-- .confirmation_box_header_wrap  -->

        	                <div class="confirmation_header_body_wrap">
        	                    <div class="confirmation_data_wrap">
        	                        <h3>${error_message}</h3>
        	                        <div class="check_img_wrap"><img src="../images/document_close.svg" class="check check_error"></div>
        	                        <div class="action_info__alert_wrap">
        	                            <div class="try_again_wrap">
        	                                <button>Try again</button>
        	                            </div>
        	                            <div class="go_back_to_note_wrap">
        	                                <a href="./notes"><button>Go back to your notes</button></a>
        	                            </div>
        	                        </div>
        	                    </div> <!-- .confirmation_data_wrap  -->
        	                </div><!-- .confirmation_header_body_wrap  -->
        	            </div><!-- .edited_note_confirmation_user_box_wrap  -->
        		    </div><!-- .show_confirmation_full_wrap  -->
        	 `;
		return s_a_box;
	}

	addEventListener_on_alert() {
		let success_alert_box = document.querySelector('.show_confirmation_full_wrap');
		let close_btn = document.querySelector('.confirmation_close_btn');
		let try_again = document.querySelector('.try_again_wrap');
		let create_new_note = document.querySelector('.create_new_note_wrap');

		close_btn.addEventListener('click', e => {
			// reseting the form when user clicks on button `create new note` on pupup modal.
			// resetCreateNewForm(ajax_form_process.form_id);
			success_alert_box.classList.add('fade_scale_out_anim');
			success_alert_box.classList.remove('fade_scale_in_anim');
			setTimeout(() => {
				// removes box when animation over
				success_alert_box.remove();
			}, 200);
		}, false);

		if (create_new_note != null) {
			create_new_note.addEventListener('click', e => {
				// reseting the form when user clicks on button `create new note` on pupup modal.
				resetCreateNewForm(ajax_form_process.form_id);
				success_alert_box.classList.add('fade_scale_out_anim');
				success_alert_box.classList.remove('fade_scale_in_anim');
				setTimeout(() => {
					// removes box when animation over
					success_alert_box.remove();
				}, 200);

				setTimeout(() => {
				  document.querySelector('.create_new_note_art').scrollIntoView({ behavior: 'smooth'});
				  document.getElementById('new_note_subject').focus();
				}, 300);
			}, false);
		}

		if (try_again != null) {
			try_again.addEventListener('click', e => {
				// reseting the form when user clicks on button `create new note` on pupup modal.
				success_alert_box.classList.add('fade_scale_out_anim');
				success_alert_box.classList.remove('fade_scale_in_anim');
				setTimeout(() => {
					// removes box when animation over
					success_alert_box.remove();
				}, 200);
			}, false);
		}

		// close popup when outside click.
		popup_close_outside_clicks('.show_confirmation_full_wrap', 'show_confirmation_full_wrap', '.show_confirmation_full_wrap .confirmation_close_btn');
	}

	show_success_alert(json) {
		document.body.insertAdjacentHTML('afterbegin', this.success_alert_box(json));
		let success_alert_box = document.querySelector('.show_confirmation_full_wrap');
		success_alert_box.classList.add('fade_scale_in_anim');
	}
	show_error_alert(error_message) {
		document.body.insertAdjacentHTML('afterbegin', this.error_alert_box(error_message));
		let error_alert_box = document.querySelector('.show_confirmation_full_wrap');
		error_alert_box.classList.add('fade_scale_in_anim');
	}
}



class editNote {
	edit_note_btn = document.querySelector('.edit_note_btn');

	success_alert_box() {
		let s_a_box = `
    	        <div class="show_confirmation_full_wrap">
    	            <div class="edited_note_confirmation_user_box_wrap">
    	                <div class="confirmation_box_header_wrap">
    	                    <span class="confirmation_header_info">Message</span>
    	                    <span class="confirmation_close_btn">X</span>
    	                </div><!-- .login_box_header_wrap  -->

    	                <div class="confirmation_header_body_wrap">
    	                    <div class="confirmation_data_wrap">
    	                        <h3>Your note has saved successfully !</h3>
    	                        <div class="check_img_wrap"><img src="../images/check.svg" class="check"></div>
    	                        <div class="action_info__alert_wrap">
    	                            <div class="edit_again_wrap">
    	                                <button>Edit again</button>
    	                            </div>
    	                            <div class="go_back_to_note_wrap">
    	                                <a href="./notes"><button>Go back to your notes</button></a>
    	                            </div>
    	                        </div>
    	                    </div> <!-- .confirmation_data_wrap  -->
    	                </div><!-- .confirmation_header_body_wrap  -->
    	            </div><!-- .edited_note_confirmation_user_box_wrap  -->
    		    </div><!-- .show_confirmation_full_wrap  -->
    	 `;
		return s_a_box;
	}
	error_alert_box(error_message) {
		let s_a_box = `
    	        <div class="show_confirmation_full_wrap">
    	            <div class="edited_note_confirmation_user_box_wrap">
    	                <div class="confirmation_box_header_wrap">
    	                    <span class="confirmation_header_info">Message</span>
    	                    <span class="confirmation_close_btn">X</span>
    	                </div><!-- .login_box_header_wrap  -->

    	                <div class="confirmation_header_body_wrap">
    	                    <div class="confirmation_data_wrap">
    	                        <h3>${error_message}</h3>
    	                        <div class="check_img_wrap"><img src="../images/document_close.svg" class="check check_error"></div>
    	                        <div class="action_info__alert_wrap">
    	                            <div class="edit_again_wrap">
    	                                <button>Edit again</button>
    	                            </div>
    	                            <div class="go_back_to_note_wrap">
    	                                <a href="./notes"><button>Go back to your notes</button></a>
    	                            </div>
    	                        </div>
    	                    </div> <!-- .confirmation_data_wrap  -->
    	                </div><!-- .confirmation_header_body_wrap  -->
    	            </div><!-- .edited_note_confirmation_user_box_wrap  -->
    		    </div><!-- .show_confirmation_full_wrap  -->
    	 `;
		return s_a_box;
	}

	addEventListener_on_alert() {
		let success_alert_box = document.querySelector('.show_confirmation_full_wrap');
		let close_btn = document.querySelector('.confirmation_close_btn');
		let edit_again = document.querySelector('.edit_again_wrap');

		close_btn.addEventListener('click', e => {
			success_alert_box.classList.add('fade_scale_out_anim');
			success_alert_box.classList.remove('fade_scale_in_anim');
			setTimeout(() => {
				// removes box when animation over
				success_alert_box.remove();
			}, 200);
		}, false);

		edit_again.addEventListener('click', e => {
			success_alert_box.classList.add('fade_scale_out_anim');
			success_alert_box.classList.remove('fade_scale_in_anim');
			setTimeout(() => {
				// removes box when animation over
				success_alert_box.remove();
			}, 200);
		}, false);

		// close popup when outside click.
		popup_close_outside_clicks('.show_confirmation_full_wrap', 'show_confirmation_full_wrap', '.show_confirmation_full_wrap .confirmation_close_btn');
	}

	show_success_alert() {
		document.body.insertAdjacentHTML('afterbegin', this.success_alert_box());
		let success_alert_box = document.querySelector('.show_confirmation_full_wrap');
		success_alert_box.classList.add('fade_scale_in_anim');
	}
	show_error_alert(error_message) {
		document.body.insertAdjacentHTML('afterbegin', this.error_alert_box(error_message));
		let error_alert_box = document.querySelector('.show_confirmation_full_wrap');
		error_alert_box.classList.add('fade_scale_in_anim');
	}
}

class parseMarkdown {
	textarea = document.getElementById('wmd-input');
	preview_md = document.getElementById('wmd-preview');
	editor;
	md_text = '';
	html_from_md = '';

	constructor() {
		this.converter = Markdown.getSanitizingConverter();

		this.converter.hooks.chain("preBlockGamut", function (text, rbg) {
			return text.replace(/^ {0,3}""" *\n((?:.*?\n)+?) {0,3}""" *$/gm, function (whole, inner) {
				return "<blockquote>" + rbg(inner) + "</blockquote>\n";
			});
		});
		
		this.editor = new Markdown.Editor(this.converter);
		this.html_from_md = this.editor.run();
	}
}


if (url_array('', 'create_note', 'user')) {
	var save_note = new saveNote;
	save_note.save_note_btn.addEventListener('click', e => {
		e.preventDefault();
		ajax_form_process.set_dynamic_values({
			e: e,
			form_id: 'create_note_form',
			which_form: 'save_note_form'
		});
		ajax_form_process.call_of_ajax({
			e: e,
			has_form: true
		});
	}, false);
} // if (url has create_note.php)


var global_note_value = {
	with_md: '',
	without_md: ''
};


let quick_note_url = url_array('', '', 'user');
console.log(quick_note_url);
// wmd-input

if ((url_array('', 'edit_note', 'user') && document.querySelector('.wmd-input') != null) || url_array('', 'create_note', 'user') || url_array('', 'user_notes') || (quick_note_url[quick_note_url.length - 2] == 'user_notes' && quick_note_url[quick_note_url.length - 1] != 'forget_password')) {
	console.log('md will use');
	var parse_md = new parseMarkdown;
	if (parse_md.textarea !== null) {
		/*parse_md.textarea.addEventListener('input', (e)=>{
			global_note_value.with_md = e.target.value;
			global_note_value.without_md = parse_md.converter.makeHtml(e.target.value);
			parse_md.preview_md.innerHTML = global_note_value.without_md;
		}, false);*/

		/*parse_md.textarea.addEventListener('input', (e)=>{

			// console.log('from AJAX - ',parse_md.editor.get_parsed_sanitised_markdown());

		}, false);*/
	}

	/* script for fetching TAGS*/
	let create_tags = new createTag;
	if (create_tags.tag_input !== null) {
		create_tags.tag_input.addEventListener('input', e => {
			create_tags.extract_tags();
		}, false);
	}

	let quick_note_div = document.querySelector('.quick_note_section');
	let editable_div = document.querySelector('.q_n_editable');
	let paswd_div = document.querySelector('.q_n_m_content .q_n_paswd');
	let paswd_input_wrap = document.querySelector('.q_n_paswd_div_main_wrap');

	
	if(quick_note_div != null){
		if(paswd_input_wrap.querySelector('#q_n_paswd_input') != null){
			let result;
			paswd_input_wrap.querySelector('#q_n_paswd_input').addEventListener('input', (e) => {
				result = String(filter_by_regex(e.target.value));
				e.target.value = result != 'null' ? result : '';
			});
		}

		// if user doesn't give the quick note id in URL then add computer generated new quick note id.
		if(get_url_file_name() == ''){
			let q_n_id = document.querySelector('.q_n_note__id').value.trim();
			let url = window.location.href.substr(0, window.location.href.lastIndexOf('/') + 1); // +1 for forward slash.
			history.pushState({}, null, url + q_n_id);
		}else{
			document.querySelector('.q_n_note__id').value = get_url_file_name();
		}
		// get correct barcode according to noteID
		document.querySelector('.q_n_bc img').src += get_url_file_name();

		quick_note_div.addEventListener('click', (e)=>{
			if(e.target.classList.contains('q_n_info_popup') && quick_note_div.querySelector('.q_n_m_content').classList.contains('show_q_n_content')){
				if(e.target.parentElement.querySelector('.q_n_link_right_sidebar_info').classList.contains('q_n_link_right_sidebar_info_show')){
					e.target.parentElement.querySelector('.q_n_link_right_sidebar_info').classList.remove('q_n_link_right_sidebar_info_show');
					e.target.classList.remove('q_n_info_popup_active');
				}else{
					if(document.querySelectorAll('.q_n_link_right_sidebar_info_show').length > 0){
						remove_class_name_multiple_ele('.q_n_m_content', 'q_n_link_right_sidebar_info_show');
						remove_class_name_multiple_ele('.q_n_m_content', 'q_n_info_popup_active');
					}
					e.target.classList.add('q_n_info_popup_active');
					e.target.parentElement.querySelector('.q_n_link_right_sidebar_info').classList.add('q_n_link_right_sidebar_info_show');
				}
			}else if(e.target.classList.contains('menu_icon')){
				if(!e.target.classList.contains('menu_active')){
					e.target.classList.add('menu_active');
				}else{
					e.target.classList.remove('menu_active');
				}
				if(quick_note_div.querySelector('.q_n_m_content').classList.contains('show_q_n_content')){
					quick_note_div.querySelector('.q_n_m_content').classList.remove('show_q_n_content');
				}else{
					quick_note_div.querySelector('.q_n_m_content').classList.add('show_q_n_content');
				}
			}else if(e.target.classList.contains('q_n_save_btn')){
				e.preventDefault();
				if(document.querySelector('.q_n_paswd_input_wrap') == null){
					ajax_form_process.set_dynamic_values({
						e: e,
						form_id: 'q_n_form',
						which_form: 'create_quick_note_form'
					});
					ajax_form_process.call_of_ajax({
						e: e,
						has_form: true
					});
				}else{
					// current note is paswd protected and
					// user trying to save note without giving password.
					Swal.fire({
						icon: 'error',
						title: 'Error',
						html: '<div class="q_n_err_popup"><div>The note you are trying to access is password protected. You first need to write correct password then only you can access the note.</div></div>' 
					  });
				}
			}
		});

		//runs on page loads		
		if(document.querySelector('#q_n_private').checked == true){
			editable_div.style.display ='none';
			paswd_div.style.display ='none';
		}else if(document.querySelector('#q_n_paswd_checkbox').checked == true){
			console.log(document.querySelector('#q_n_paswd_checkbox').checked);
			console.log(document.querySelector('#q_n_private').checked);
			paswd_input_wrap.style.display = 'block';
		}

		document.querySelectorAll('.q_n_check_auth').forEach((element, index) => {
			element.addEventListener('change', (e)=>{
				if(e.target.classList.contains('q_n_private')){
					if(editable_div.style.display == '' || editable_div.style.display == 'block' || paswd_div.style.display=='' || paswd_div.style.display=='block'){
						editable_div.style.display = 'none';
						paswd_div.style.display= 'none';
					}else{
						editable_div.style.display = '';
						paswd_div.style.display = '';
						editable_div.style.animation = 'bi_dir_width 0.3s cubic-bezier(0.68, 0.18, 0.09, 1.05) reverse';
						paswd_div.style.animation = 'bi_dir_width 0.3s cubic-bezier(0.68, 0.18, 0.09, 1.05) reverse';
						setTimeout(() => {
						  editable_div.style.animation='';
						  paswd_div.style.animation='';
						}, 300);
					} 
				}else if(e.target.classList.contains('q_n_paswd_in_ch')){
					if(paswd_input_wrap.style.display == '' || paswd_input_wrap.style.display == 'none'){
						paswd_input_wrap.style.display = 'block';
						paswd_input_wrap.style.animation = 'bi_dir_width 0.5s cubic-bezier(0.68, 0.18, 0.09, 1.05) reverse';
						setTimeout(() => {
						  paswd_input_wrap.style.animation='';
						}, 500);
					}else{
						paswd_input_wrap.style.display = 'none';
					}
				}
			});
		});


			let barcode_img = document.querySelector('.q_n_bc img');
			document.querySelector('.q_n_note__id').addEventListener('input', (e)=>{
				// fitering user input
				if(e.target.value.trim().length == 0){
					return false;
				}

				let result = String(filter_by_regex(e.target.value));
				e.target.value = result != 'null' ? result : '';
				// updating barcode src of image according to user input.
				let last_index = barcode_img.src.trim().lastIndexOf('=')+1;
				if(last_index > 0 && result.length < 13 && result.length > 0){
					barcode_img.src=barcode_img.src.trim().substring(0,last_index) +  result;
				}
			});	
	}


	var edit_note = new editNote;
	if (edit_note.edit_note_btn != null) {
		edit_note.edit_note_btn.addEventListener('click', e => {
			e.preventDefault();
			ajax_form_process.set_dynamic_values({
				e: e,
				form_id: 'edit_note_form',
				which_form: 'edit_note_form'
			});
			ajax_form_process.call_of_ajax({
				e: e,
				has_form: true
			});
		}, false);
	}
}

class viewSingleNote {
	// note_id = '';
	// increase view of the note by 1 in MYSQL DB.
	increase_note_view_in_DB() {
		let single_note_div = document.getElementById('view_single_note');
		if (single_note_div !== null) {
			let note_id = single_note_div.querySelector('.show_more_note_wrap');
			if (note_id != null) {
				note_id = note_id.getAttribute('data-src');
				show_more_note.note_id = note_id;
				ajax_form_process.set_dynamic_values({
					e: '',
					form_id: '',
					which_form: 'increase_note_view_in_DB'
				});
				ajax_form_process.call_of_ajax({
					e: '',
					has_form: false
				});
			}
		}
	}


	action_message() {
		let html = `
		<article class="s_v_note_action_wrap">
		<div class="go_back_wrap">
			<button onclick="goBack()">Go Back</button>
			</div>
			<div class="create_note_link">
			<a href="./create_note.php">Create new note</a>
			</div>
		</article>
		`;
		return html;
	}

	add_action_message(class_name) {
		let container = document.querySelector('.' + class_name);
		if (container != null) {
			container.innerHTML = this.action_message();
		}
	}


}



class showMoreNote {
	note_id = '';
	show_more_text = 'Show more';
	show_less_text = 'Show less';
	first_container_note = document.querySelector('.all_notes_art_wrap');
	clicked_main_element = '';
	// Used for setting the offset in SQL query in PHP
	// this variable will be attach in AJAX [GET] request
	// It will increment by 1 every time when we send an AJAX request.
	page = 0;

	remove_deleted_element() {
		if (this.deleted_note_element != null) {
			anime({
				targets: this.deleted_note_element,
				delay: 600,
				height:[this.deleted_note_element.offsetHeight, 0],
				easing: 'easeOutExpo',
				duration: 3000,
				opacity:[1,0.5],
				custom_f: setTimeout(() => {
					this.deleted_note_element.remove();
					// run only if page url is view_note.php
					if(get_url_file_name().includes('view_note')){
					document.querySelector('.all_notes_art_wrap').insertAdjacentHTML('afterbegin',`
					<article class="note_wrap" style="border:1px solid #ffc800;">
						<div class="current_note_deleted">This note has been deleted.</div>                        
					</article>
					`);
					anime({
						targets: '.note_wrap',
						height:[0,document.querySelector('.note_wrap').offsetHeight - 12],
						easing: 'easeInExpo',
						duration: 500,
						opacity:[0.5,1]
					});
				}

				}, 3600)
			});
		}

	}


	addEventListener_on_showMore() {
		// small TV divs.
		let show_more_btn_wrap = document.querySelectorAll('.show_more_note_wrap');
		show_more_btn_wrap.forEach((element, index) => {
			if (element.getAttribute('data-event') != 'true') {
				element.setAttribute('data-event', 'true');
				element.addEventListener('click', e => {
					// display popup of the full note content
					this.clicked_main_element = element.closest('.note_wrap');
					this.show_more_note_content(e);
					// adding click event on watch later button present in popup
					watchLater.add_event_list_on_watchLaterButton_on_popup();
					saveNoteAsImportant.add_event_list_on_impButton_on_popup();
					click_event_on_delete_btn_on_popup(element.closest('.note_wrap'));
					// popup will close when clicked outside.
					popup_close_outside_clicks('#show_note_popup', 'show_note_popup_anim', '#show_note_popup .confirmation_close_btn');


					// setting scroll position to previous scrolled position which is saved in local storage.
					if(localStorage[document.querySelector('#show_note_popup .save_to_pocket_wrap').getAttribute('data-src')]){
						document.querySelector('#show_note_popup .note_wrap').scrollTop = 
					localStorage[document.querySelector('#show_note_popup .save_to_pocket_wrap').getAttribute('data-src')];
					}
				}, false);
			}
		});

	}

	addEventListener_on_delete() {
		let delete_btns = document.querySelectorAll('.note_delete_wrap');
		delete_btns.forEach((element, index) => {
			if (element.getAttribute('data-event') != 'true') {
				element.setAttribute('data-event', 'true');
				element.addEventListener('click', e => {
					this.note_id = e.target.getAttribute('data-src');
					this.deleted_note_element = element.closest('.note_wrap');
					this.clicked_main_element = this.deleted_note_element;
					// display popup of the full note content with a delete button at the top.
					this.show_more_note_content_for_delete(e);
					// adding click event on `watch later` button and `save as imp` button present in popup
					watchLater.add_event_list_on_watchLaterButton_on_popup();
					saveNoteAsImportant.add_event_list_on_impButton_on_popup();

					// adding event on delete button which is present in popup.
					// add click event on delete button to call AJAX to delete the note.
					let delete_btn = document.querySelector('#show_note_popup .delete_btn_of_popup');
					if (delete_btn == null) {
						return false;
					}
					if (delete_btn.getAttribute('data-click-event') != 'true') {
						delete_btn.setAttribute('data-click-event', 'true');
						delete_btn.addEventListener('click', e => {
							ajax_form_process.set_dynamic_values({
								e: '',
								form_id: '',
								which_form: 'delete_note_of_popup'
							});
							ajax_form_process.call_of_ajax({
								e: e,
								has_form: false
							});
						}, false);
					}
				}, false);
			}
		});
	}

	get_user_notes_by_AJAX() {
		ajax_form_process.set_dynamic_values({
			e: '',
			form_id: '',
			which_form: 'load_user_notes'
		});
		ajax_form_process.call_of_ajax({
			e: 'all_notes_art_wrap',
			has_form: false
		});
	}

	// this will increase the height of the note content to show the full view.
	show_more(e) {
		// Fetching parsed markdown text
		let next = e.target.nextElementSibling;
		if (next.clientHeight == next.scrollHeight) {
			e.target.children[0].textContent = this.show_more_text;
			/* I have set height from CSS property.
			 *  So no need to set height from here.
			 */
			// next.style.height = '150px';
		} else {
			next.style.height = next.scrollHeight + 'px';
			this.show_less(e);
		}
	}

	close_btn_function(popup_note) {
		popup_note.classList.remove('show_note_popup_anim');
		document.body.classList.remove('body_stop_scroll_vert');
		popup_note.classList.add('remove_note_popup_anim');
		setTimeout(() => {
			popup_note.remove();
		}, 500);
	}

	// adding event on close button
	add_event_on_show_more_note_content() {
		console.log('adding click..............');
		let popup_note = document.getElementById('show_note_popup');
		let close_btn = popup_note.querySelector('.confirmation_close_btn');
		close_btn.addEventListener('click', () => {
			this.close_btn_function(popup_note);
			//saving current scroll position in HTML5 localStorage
			localStorage[popup_note.querySelector('.save_to_pocket_wrap').getAttribute('data-src')] = popup_note.querySelector('.note_wrap').scrollTop;
		}, false);
	}

	// increase view of the note by 1 in MYSQL DB.
	increase_note_view_in_DB(e) {
		let popup_div = document.getElementById('show_note_popup');
		if (popup_div !== null) {
			if (e.target.getAttribute('data-src') == popup_div.querySelector('.show_more_note_wrap').getAttribute('data-src')) {
				this.note_id = e.target.getAttribute('data-src');
				ajax_form_process.set_dynamic_values({
					e: '',
					form_id: '',
					which_form: 'increase_note_view_in_DB'
				});
				ajax_form_process.call_of_ajax({
					e: '',
					has_form: false
				});
			}
		}
	}

	// this is the popup of the full note content of a single note.
	show_more_note_content(e) {
		// Fetching and creating a single note for popup
		let note_wrap = e.target.closest('.note_wrap');
		let note_html = this.show_more_note_content_div_wrap(note_wrap);

		document.body.insertAdjacentHTML('beforeend', note_html);
		document.body.classList.add('body_stop_scroll_vert');
		// adding event on close button on small tv popup
		this.add_event_on_show_more_note_content();


		setTimeout(() => {
			this.increase_note_view_in_DB(e);
		}, 8000);

	}
	// this is the popup of the full note content of a single note.
	show_more_note_content_for_delete(e) {
		// Fetching and creating a single note for popup
		let note_html = this.delete_note_html_wrap(e.target.closest('.note_wrap'));
		document.body.insertAdjacentHTML('beforeend', note_html);
		let delete_btn_of_note = document.querySelector('#show_note_popup .note_delete_wrap');
		if (delete_btn_of_note !== null) {
			delete_btn_of_note.remove();
		}
		document.body.classList.add('body_stop_scroll_vert');
		// adding event on close button
		this.add_event_on_show_more_note_content();
		// adding event on outside click to close the popup.
		popup_close_outside_clicks('#show_note_popup', 'show_note_popup_anim', '#show_note_popup .confirmation_close_btn');
	}


	show_more_note_content_div_wrap(note_html) {
		let popup_note_html = `
		<div id="show_note_popup" class="show_note_popup_anim">
            <div class="edited_note_confirmation_user_box_wrap">
                <div class="confirmation_box_header_wrap">
                    <span class="confirmation_header_info">Note</span>
                    <span class="confirmation_close_btn">X</span>
                </div><!-- .login_box_header_wrap  -->

                <div class="confirmation_header_body_wrap">
                    <div class="confirmation_data_wrap">
                      ${note_html.outerHTML}
                    </div> <!-- .confirmation_data_wrap  -->
                </div><!-- .confirmation_header_body_wrap  -->
            </div><!-- .edited_note_confirmation_user_box_wrap  -->
		</div>`;
		return popup_note_html;
	}

	delete_note_html_wrap(note_html) {
		let note_id = note_html.querySelector('.note_delete_btn').getAttribute('data-src');
		if (note_id == null) {
			return false;
		}
		let popup_delete_note_html = `
		<div id="show_note_popup" class="show_note_popup_anim show_note_popup_for_del_confirm">
		    <div class="edited_note_confirmation_user_box_wrap">
		        <div class="confirmation_box_header_wrap">
		            <span class="confirmation_header_info">Note</span>
		            <span class="confirmation_close_btn">X</span>
		        </div><!-- .login_box_header_wrap  -->

		        <div class="confirmation_header_body_wrap">
		            <div class="delete_note_confirm_wrap">
		                <div>
		                    <h3>
		                        Are you sure to delete this note ?
		                    </h3>
		                    <div class="delete_img_wrap">
		                        <span class="material-icons delete_confirm">delete</span>
		                    </div>
		                       <button data-src="${note_id}" class="delete_btn_of_popup">Delete</button> 
		                </div>
		            </div>
		            <div class="confirmation_data_wrap">
		              ${note_html.outerHTML}
		            </div> <!-- .confirmation_data_wrap  -->
		        </div><!-- .confirmation_header_body_wrap  -->
		    </div><!-- .edited_note_confirmation_user_box_wrap  -->
		</div>`;
		return popup_delete_note_html;
	}

	show_less(e) {
		// parsed markdown text
		e.target.children[0].textContent = this.show_less_text;
	}

	load_more_notes() {
		let container = document.querySelector('.prev_notes_art');
		let content_height = container.offsetHeight;
		let current_y = window.innerHeight + window.pageYOffset;
		// console.log(current_y + '/' + content_height);
		if (current_y >= content_height) {
			// Load more user's note.
			if (!ajax_form_process.request_in_progess) {
				show_more_note.get_user_notes_by_AJAX();
			}
		}
	}

	// Give a message that no more note is left to show to you.
	no_more_note(message) {
		if (this.page === null) {
			let no_more_note_html = `
			<span class="no_more_note_wrap">
			<span class="no_more_note_message">${message}</span>
			</span>
			`;
			return no_more_note_html;
		}
	}
}

class show_alert_like_PUBG {
	static show_message(message, targeted_element) {
		let create_element = document.createElement('div');
		create_element.className = 'popup_time_out_message';
		create_element.innerHTML = message;
		targeted_element.appendChild(create_element);
		setTimeout(() => {
			create_element.remove();
		}, 5000);
	}

	static show_action_message(message, targeted_element) {
		let create_element = document.createElement('div');
		create_element.className = 'popup_time_out_action_message';
		create_element.innerHTML = message;
		targeted_element.appendChild(create_element);
		setTimeout(() => {
			create_element.remove();
		}, 2000);
	}
}

class watchLater {
	static note_id;
	targeted_element;
	first_container_note = document.querySelector('.all_notes_title_wrap');
	// Used for setting the offset in SQL query in PHP
	// this variable will be attach in AJAX [GET] request
	// It will increment by 1 every time when we send an AJAX request.
	page = 0;

	get_watch_later_notes_by_AJAX() {
		ajax_form_process.set_dynamic_values({
			e: '',
			form_id: '',
			which_form: 'load_watch_later_notes'
		});
		ajax_form_process.call_of_ajax({
			e: 'all_watch_later_notes_wrap',
			has_form: false
		});
	}

	load_more_watch_later_notes() {
		let container = document.querySelector('.notes_title_art');
		let content_height = container.offsetHeight;
		let current_y = window.innerHeight + window.pageYOffset;
		if (current_y >= content_height) {
			// Load more user's note.
			if (!ajax_form_process.request_in_progess) {
				this.get_watch_later_notes_by_AJAX();
			}
		}
	}

	static add_event_list_on_watchLaterButton() {
		let btns = document.querySelectorAll('.note_wrap .save_to_pocket_wrap');
		if (btns.length > 0) {
			btns.forEach(element => {
				if (element.getAttribute('data-event') != 'true') {
					element.setAttribute('data-event', 'true');
					element.addEventListener('click', (e) => {
						this.targeted_element = element;
						this.note_id = element.getAttribute('data-src');
						ajax_form_process.set_dynamic_values({
							e: '',
							form_id: '',
							which_form: 'watch_later'
						});
						ajax_form_process.call_of_ajax({
							e: '',
							has_form: false
						});
					}, false);
				}
			});
		}
	}

	static add_event_list_on_watchLaterButton_on_popup() {
		let btns = document.querySelectorAll('#show_note_popup .save_to_pocket_wrap');
		if (btns.length > 0) {
			btns.forEach(element => {
				if (element.getAttribute('data-click-event') != 'true') {
					element.setAttribute('data-click-event', 'true');
					element.addEventListener('click', (e) => {
						this.targeted_element = element;
						this.note_id = element.getAttribute('data-src');
						ajax_form_process.set_dynamic_values({
							e: '',
							form_id: '',
							which_form: 'watch_later'
						});
						ajax_form_process.call_of_ajax({
							e: '',
							has_form: false
						});
					}, false);
				}
			});
		}
	}

	static update_image_watch_later(json) {
		let image = this.targeted_element.querySelector('.save_to_pocket_img');
		if (json.current_watch_later_value == 1) {
			image.classList.add('user_note_action_success');
		} else {
			image.classList.remove('user_note_action_success');
		}
		/* Updating image location on both `main note`` and `popup`.*/
		if (document.getElementById('show_note_popup') != null && show_more_note.clicked_main_element != null) {
			if (json.current_watch_later_value == 1) {
				show_more_note.clicked_main_element.querySelector('.save_to_pocket_img').classList.add('user_note_action_success');
			} else {
				show_more_note.clicked_main_element.querySelector('.save_to_pocket_img').classList.remove('user_note_action_success');
			}
		}

		anime({
			targets: image,
			scale: [0, 1],
			opacity: [0, 1],
			easing: 'easeOutElastic(1, .5)'
		});
	}

	// Give a message that no more note is left to show to you.
	no_more_note(message) {
		if (this.page === null) {
			let no_more_note_html = `
				<div id="json_subject_message">
					<span class="no_more_note_wrap">
					<span class="no_more_note_message">${message}</span>
					</span>
				</div>
				`;

			return no_more_note_html;
		}
	}
} // watchLater

// Load all previously saved watch later notes of a user.
// used in watch_later.php
var watch_later = new watchLater;
if (window.location.href.search('user/watch_later') >= 0) {
	watch_later.get_watch_later_notes_by_AJAX();
	// every time page get scroll it will fire scroll event.
	window.onscroll = () => {
		if (watch_later.page !== null) {
			watch_later.load_more_watch_later_notes();
		}
	}
}


class saveNoteAsImportant {
	static note_id;
	targeted_element;
	first_container_note = document.querySelector('.all_notes_title_wrap');
	// Used for setting the offset in SQL query in PHP
	// this variable will be attach in AJAX [GET] request
	// It will increment by 1 every time when we send an AJAX request.
	page = 0;

	get_saved_imp_notes_by_AJAX() {
		ajax_form_process.set_dynamic_values({
			e: '',
			form_id: '',
			which_form: 'load_saved_imp_notes'
		});
		ajax_form_process.call_of_ajax({
			e: 'all_saved_imp_notes_wrap',
			has_form: false
		});
	}

	load_more_imp_notes() {
		let container = document.querySelector('.notes_title_art');
		let content_height = container.offsetHeight;
		let current_y = window.innerHeight + window.pageYOffset;
		if (current_y >= content_height) {
			// Load more user's note.
			if (!ajax_form_process.request_in_progess) {
				this.get_saved_imp_notes_by_AJAX();
			}
		}
	}

	static add_event_list_on_impButton() {
		let btns = document.querySelectorAll('.note_wrap .mark_as_imp_wrap');
		if (btns.length > 0) {
			btns.forEach(element => {
				if (element.getAttribute('data-event') != 'true') {
					element.setAttribute('data-event', 'true');
					element.addEventListener('click', (e) => {
						this.targeted_element = element;
						this.note_id = element.getAttribute('data-src');
						ajax_form_process.set_dynamic_values({
							e: '',
							form_id: '',
							which_form: 'imp_notes'
						});
						ajax_form_process.call_of_ajax({
							e: '',
							has_form: false
						});
					}, false);
				}
			});
		}
	}

	static add_event_list_on_impButton_on_popup() {
		let btns = document.querySelectorAll('#show_note_popup .mark_as_imp_wrap');
		if (btns.length > 0) {
			btns.forEach(element => {
				if (element.getAttribute('data-click-event') != 'true') {
					element.setAttribute('data-click-event', 'true');
					element.addEventListener('click', (e) => {
						this.targeted_element = element;
						this.note_id = element.getAttribute('data-src');
						ajax_form_process.set_dynamic_values({
							e: '',
							form_id: '',
							which_form: 'imp_notes'
						});
						ajax_form_process.call_of_ajax({
							e: '',
							has_form: false
						});
					}, false);
				}
			});
		}
	}

	static update_image_imp_note(json) {
		let image = this.targeted_element.querySelector('.mark_as_imp_img');
		if (json.current_imp_note_value == 1) {
			image.classList.add('user_note_action_success');
		} else {
			image.classList.remove('user_note_action_success');
		}
		/* Updating image location on both `main note`` and `popup`.*/
		if (document.getElementById('show_note_popup') != null && show_more_note.clicked_main_element != null) {
			if (json.current_imp_note_value == 1) {
				show_more_note.clicked_main_element.querySelector('.mark_as_imp_img').classList.add('user_note_action_success');
			} else {
				show_more_note.clicked_main_element.querySelector('.mark_as_imp_img').classList.remove('user_note_action_success');
			}
		}
		anime({
			targets: image,
			scale: [0, 1],
			opacity: [0, 1],
			easing: 'easeOutElastic(1, .5)'
		});
	}

	// Give a message that no more note is left to show to you.
	no_more_note(message) {
		if (this.page === null) {
			let no_more_note_html = `
				<div id="json_subject_message">
					<span class="no_more_note_wrap">
					<span class="no_more_note_message">${message}</span>
					</span>
				</div>
				`;

			return no_more_note_html;
		}
	}
} // saveNoteAsImportant



// Load all previously saved watch later notes of a user.
// used in watch_later.php
var imp_note = new saveNoteAsImportant;
if (window.location.href.search('user/important_notes') >= 0) {
	imp_note.get_saved_imp_notes_by_AJAX();
	// every time page get scroll it will fire scroll event.
	window.onscroll = () => {
		if (imp_note.page !== null) {
			imp_note.load_more_imp_notes();
		}
	}
}

var show_more_note = new showMoreNote;
if (window.location.href.search('user/view_note') >= 0) {
	watchLater.add_event_list_on_watchLaterButton();
	saveNoteAsImportant.add_event_list_on_impButton();
}


class Subject {
	first_container_note = document.querySelector('.subjects_info_art')
	subject_tiles_wrap = document.querySelector('#subject_tiles_wrap');
	// Used for setting the offset in SQL query in PHP
	// this variable will be attach in AJAX [GET] request
	// It will increment by 1 every time when we send an AJAX request.
	page = 0;
	load_more_subjects() {
		let container = document.querySelector('.show_subjects_wrap');
		let content_height = container.offsetHeight;
		let current_y = window.innerHeight + window.pageYOffset;
		// console.log(current_y + '/' + content_height);
		if (current_y >= content_height) {
			// Load more user's note.
			if (!ajax_form_process.request_in_progess) {
				this.get_subjects_by_AJAX();
			}
		}
	}

	get_subjects_by_AJAX() {
		ajax_form_process.set_dynamic_values({
			e: '',
			form_id: '',
			which_form: 'load_user_subjects'
		});
		ajax_form_process.call_of_ajax({
			e: 'subjects_info_art',
			has_form: false
		});
	}

	get_subject_notes_AJAX() {
		ajax_form_process.set_dynamic_values({
			e: '',
			form_id: '',
			which_form: 'load_user_subject_notes',
			url_param: get_url_params(window.location.href, 'subjectName')
		});
		ajax_form_process.call_of_ajax({
			e: 'subjects_info_art',
			has_form: false
		});
	}

	// Give a message that no more note is left to show to you.
	no_more_note(message) {
		if (this.page === null) {
			let no_more_note_html = `
			<div id="json_subject_message">
				<span class="no_more_note_wrap">
				<span class="no_more_note_message">${message}</span>
				</span>
			</div>
			`;

			return no_more_note_html;
		}
	}



}


// Load all previously saved notes of a user.
// var show_more_note = new showMoreNote;
if (window.location.href.search('user/notes') >= 0) {
	show_more_note.get_user_notes_by_AJAX();
	// every time page get scroll it will fire scroll event.
	window.onscroll = () => {
		if (show_more_note.page !== null) {
			show_more_note.load_more_notes();
		}
	}
}

// Load all previously saved subjects of a user.
var subjects = new Subject;
if (window.location.href.search('user/subjects') >= 0) {
	if (!url_has_params(window.location.href)) {
		subjects.get_subjects_by_AJAX();
		window.onscroll = () => {
			if (subjects.page !== null) {
				subjects.load_more_subjects();
			}
		}
	} else {
		/* If url has [GET] parameters then it will only +
		 + show the notes of a single subject.
		*/
		// let subjectName = get_url_params(window.location.href, 'subjectName');
		subjects.get_subject_notes_AJAX();
		window.onscroll = () => {
			if (subjects.page !== null) {
				subjects.get_subject_notes_AJAX();
			}
		}
	}
}

class noteTitle {
	note_id = '';
	first_container_note = document.querySelector('.all_notes_title_wrap');
	// Used for setting the offset in SQL query in PHP
	// this variable will be attach in AJAX [GET] request
	// It will increment by 1 every time when we send an AJAX request.
	page = 0;
	get_user_notes_by_AJAX() {
		ajax_form_process.set_dynamic_values({
			e: '',
			form_id: '',
			which_form: 'load_user_notes_title'
		});
		ajax_form_process.call_of_ajax({
			e: 'all_notes_title_wrap',
			has_form: false
		});
	}

	load_more_notes() {
		let container = document.querySelector('.notes_title_art');
		let content_height = container.offsetHeight;
		let current_y = window.innerHeight + window.pageYOffset;
		// console.log(current_y + '/' + content_height);
		if (current_y >= content_height) {
			// Load more user's note.
			if (!ajax_form_process.request_in_progess) {
				this.get_user_notes_by_AJAX();
			}
		}
	}

	// Give a message that no more note is left to show to you.
	no_more_note(message) {
		if (this.page === null) {
			let no_more_note_html = `
			<div id="json_subject_message">
				<span class="no_more_note_wrap">
				<span class="no_more_note_message">${message}</span>
				</span>
			</div>
			`;

			return no_more_note_html;
		}
	}
}



class sendMail {
	// when a user subscribed
	subscription_send_mail() {
		let form_btn = document.querySelector('#subsc_form .btn');
		let input = document.querySelector('#subsc_form .subsc_email');
		if (form_btn == null) {
			return;
		}
		form_btn.addEventListener('click', (e) => {
			e.preventDefault();
			if (input.value.trim() == '') {
				shake_element('#subsc_form .subsc_email');
				return false;
			} else if (ajax_form_process.request_in_progess != false) {
				return;
			}
			ajax_form_process.set_dynamic_values({
				e: e,
				form_id: 'subsc_form',
				which_form: 'subscription_form'
			});
			ajax_form_process.call_of_ajax({
				e: e,
				has_form: true
			});
		}, false);
	}

	// When user send any message to developer.
	message_send_mail() {
		let form_btn = document.querySelector('#send_msg_to_admin_form .btn');
		let input = document.querySelector('#send_msg_to_admin_form #contact_info');
		if (form_btn == null) {
			return;
		}
		form_btn.addEventListener('click', (e) => {
			e.preventDefault();
			if (input.value.trim() == '') {
				shake_element('#send_msg_to_admin_form #contact_info');
				return;
			} else if (ajax_form_process.request_in_progess != false) {
				return;
			}
			ajax_form_process.set_dynamic_values({
				e: e,
				form_id: 'send_msg_to_admin_form',
				which_form: 'message_to_developer_form'
			});
			ajax_form_process.call_of_ajax({
				e: e,
				has_form: true
			});
		}, false);
	}


}

var send_mail = new sendMail;

send_mail.subscription_send_mail();
send_mail.message_send_mail();

class showSearchSuggestion {
	show_suggestion_for_subject_name(html) {
		this.reset_suggestion('subject_suggestion');
		let input_container = document.querySelector('.span_input_wrap');
		if (input_container != null) {
			input_container.insertAdjacentHTML('beforeend', html);
			this.fill_input_for_subject_name();
			add_anim_in_suggestion({
				class_name: '.subject_suggestion .s_s_result',
				animation_name: 'moving_color',
				multiple_time: 20,
				set_time: 100
			});
		}
	}

	show_suggestion_for_notes(html) {
		this.reset_suggestion('search_sugg_notes');
		let input_container = document.querySelector('.input_search_close_wrap');
		if (input_container != null) {
			input_container.insertAdjacentHTML('beforeend', html);
			add_anim_in_suggestion({
				class_name: '.search_sugg_notes .s_s_result',
				animation_name: 'moving_color',
				multiple_time: 20,
				set_time: 100
			});
		}
	}
	reset_suggestion(class_name) {
		let sg = document.querySelectorAll('.' + class_name);
		if (sg.length == 0) return false;
		sg.forEach(element => {
			element.remove();
		});
	}

	fill_input_for_subject_name() {
		let input = document.getElementById('new_note_subject');
		let s_names = document.querySelector('.subject_suggestion');
		if (s_names != null && input != null) {
			s_names.addEventListener('click', e => {
				if (e.target.classList.contains('s_s_result')) {
					input.value = e.target.textContent.trim();
					s_names.remove();
				}
			}, false);
		}
	}
}

var search_suggestion = new showSearchSuggestion;

// Load all previously saved notes title of a user.
// used in topic.php
var note_title = new noteTitle;
if (window.location.href.search('user/topic') >= 0) {
	note_title.get_user_notes_by_AJAX();
	// every time page get scroll it will fire scroll event.
	window.onscroll = () => {
		if (note_title.page !== null) {
			note_title.load_more_notes();
		}
	}
}

if (window.location.href.search('user/view_note') >= 0) {
	show_more_note.addEventListener_on_delete();
	var view_single_note = new viewSingleNote;
	setTimeout(() => {
		view_single_note.increase_note_view_in_DB();
	}, 8000);
}



// animation in tags.php page



if (window.location.href.search('user/tags') >= 0) {
	add_anim_in_suggestion({
		class_name: '.notes_tag_page .notes_tag_link',
		animation_name: 'moving_color_pink',
		multiple_time: 10,
		set_time: 100
	});
	let all_tags = document.querySelectorAll('.all_notes_title_wrap .notes_tag_link');
	console.log(all_tags);
	all_tags.forEach(element => {
		element.addEventListener('click', (e) => {
			console.log(e.target.innerHTML);
			Swal.fire({
				title: '<div class="title_popup"><span class="material-icons tag_label popup_tag_icon">label</span>' + '<strong>' + e.target.innerHTML + '</strong></div>',
				width: 600,
				html: '<big>Given below are the links which is related to the tag <b>' + e.target.querySelector('.tag_name_text').textContent + '</b> :<br><hr> </big>' +
					e.target.parentElement.querySelector('.links_wrap').innerHTML,
				showCloseButton: true
			})
		}, false);
	});
}


setTimeout(() => {
	let admin_banner = document.querySelector('a[href^="https://www.000webhost.com"]');
	if (admin_banner != null) {
		admin.banner.parentElement.remove();
	}
}, 500);

// AJAX for getting notes of logedin user

// show `create_new_note` option on click on burger icon --STARTS

class navBar {
	static add_event_short_navBar() {
		let burger_icon = document.querySelector('.burger_icon');
		if (burger_icon != null) {
			// adding event
			burger_icon.addEventListener('click', () => {
				show_menus_short();
			}, false);

		}
	}
}

if (document.querySelector('.burger_icon') != null) {
	navBar.add_event_short_navBar();
}


// show create_new_note` option on click on burger icon -------------ENDS
/* save note process -----------ENDS*/
