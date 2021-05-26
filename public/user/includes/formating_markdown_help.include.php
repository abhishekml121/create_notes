<section class="formating_markdown_help hide">
	<div class="formating_header">
		<span class="links_help f_help_child" data-tab-id="1"><span class="f_help_text active_tab" data-tab-id="1">Links</span></span>
		<span class="images_help f_help_child" data-tab-id="2"><span class="f_help_text" data-tab-id="2">Images</span></span>
		<span class="headers_help f_help_child" data-tab-id="3"><span class="f_help_text" data-tab-id="3">Styling/Headers</span></span>
		<span class="lists_help f_help_child" data-tab-id="4"><span class="f_help_text" data-tab-id="4">Lists</span></span>
		<span class="blockquote_help f_help_child" data-tab-id="5"><span class="f_help_text" data-tab-id="5">Blockquotes</span></span>
		<span class="code_help f_help_child" data-tab-id="6"><span class="f_help_text" data-tab-id="6">Code</span></span>
		<span class="html_help f_help_child" data-tab-id="7"><span class="f_help_text" data-tab-id="7">HTML</span></span>
		<span class="more_help f_help_child" data-tab-id="8"><a href="#" class="f_help_text_link no_underline"><span class="f_help_text" data-tab-id="7">more</span>
			<div class="svg_more_help_div">
				<svg aria-hidden="true" class="va-middle svg-icon iconShareSm" width="14" height="14" viewBox="0 0 14 14"><path d="M5 1H3a2 2 0 00-2 2v8c0 1.1.9 2 2 2h8a2 2 0 002-2V9h-2v2H3V3h2V1zm2 0h6v6h-2V4.5L6.5 9 5 7.5 9.5 3H7V1z"></path>
				</svg>
			</div>
			</a>
		</span>
	</div><!-- .formating_header -->
	<div class="formating_markdown_help_body">
		<article class="f_body_help_art tab1_data show" data-tab-id="1">
			<p class="help_body_head">Use angle brackets to force linking</p>
			<div class="help_body_info">&lt;https://stackoverflow.com&gt;</div>
			<p class="help_body_head">Create inline text links with Markdown</p>
			<div class="help_body_info">[Text](https://stackoverflow.com)</div>
			<p class="help_body_head">Add alt attributes to links by adding a double space and text after the URL</p>
			<div class="help_body_info">[Text](https://stackoverflow.com<code class="db_space">&nbsp;&nbsp;</code>"this text appears on mouseover")</div>
		</article>

		<article class="f_body_help_art tab2_data hide" data-tab-id="2">
			<p class="help_body_head">Add inline images</p>
			<div class="help_body_info">![Text](https://stackoverflow.com/image.jpg)</div>
		</article>

		<article class="f_body_help_art tab3_data hide" data-tab-id="3">
			<p class="help_body_head">Use some text styling to make your post more readable</p>
			<div class="help_body_info">
				<div class="seprate_data">
					<span class="tab_label">Line breaks: </span><span class="tab_label_data">double space or <span class="tab_label_br">&lt;br /&gt;</span> at the end of each line</span>
				</div>
				<div class="seprate_data">
					<span class="tab_label"><i>Italics: </i></span><span class="tab_label_data">*asterisks* or _underscores_
						<div><span class="light_bold"><b>Bold:</b></span> **double asterisks** or __double underscores_</div>
					</span>
				</div>
			</div>

			<p class="help_body_head">Create sections with headers</p>
			<div class="help_body_info">
				<div>A Large Header</div>
				<div>==============</div>
			</div>
			<div class="help_body_info">
				<div>Smaller Subheader</div>
				<div>--------------</div>
			</div>

			<p class="help_body_head">Use hash marks for multiple levels of headers</p>
			<div class="help_body_info">
				<div>
					# Header 1 #
				</div>
				<div>
					## Header 2 ##
				</div>
				<div>
					### Header 3 ###
				</div>
			</div>
		</article>

		<article class="f_body_help_art tab4_data hide"  data-tab-id="4">
			<p class="help_body_head">Create bulleted and numbered lists</p>
			<div class="help_body_info">
				<div>- Create bullets with minus sign</div>
				<div>+ or plus sign</div>
				<div>* or an asterisk</div>
				<div>1. or sequential numbers</div>
			</div>
			<p class="help_body_head">Use 4 or 8 spaces to create nested lists</p>
			<div class="help_body_info">
				<div>1. List item</div>
				<div><span class="db_space">&nbsp;&nbsp;&nbsp;&nbsp;</span>- Item A, four spaces</div>
				<div><span class="db_space">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>* Item B, eight spaces</div>
			</div>
		</article>

		<article class="f_body_help_art tab5_data hide" data-tab-id="5">
			<p class="help_body_head">Add > to the beginning of each line to create a blockquote</p>
			<div class="help_body_info">							
				<div>> A standard blockquote is indented</div>
				<div>> > A nested blockquote is indented more</div>
				<div>> > > > You can nest to any depth.</div>
			</div>
		</article>

		<article class="f_body_help_art tab6_data hide" data-tab-id="6">
			<p class="help_body_head">Create code fences by placing your code between sets of 3 backticks ` or use CTRL + K</p>
			<div class="help_body_info">							
				<code class="code_help_data_in">
					<div>```</div>
					<div>like so</div>
					<div>```</div>
				</code>
			</div>
			<p class="help_body_head">Create inline code spans by placing text between single backticks</p>
			<div class="help_body_info">					
				<code class="code_help_data_in">`like so`</code>
			</div>
		</article>

		<article class="f_body_help_art tab7_data hide" data-tab-id="7">
			<p class="help_body_head">Use HTML in combination with Markdown <span class="no_bold">(</span><a href="https://meta.stackexchange.com/questions/1777/what-html-tags-are-allowed-on-stack-exchange-sites" target ="_blank" class="no_underline header_link_tab_body">What's supported? Note: We advise against mixing HTML and Markdown.</a><span class="no_bold">)</span></p>
			<div class="help_body_info">					
				&lt;strike&gt;Markdown works * fine* in here.&lt;/strike&gt;
			</div>
			<p class="help_body_head">Block-level HTML elements have restrictions</p>
			<div class="help_body_info">
				<div>1. Use blank lines to separate them from surrounding text</div>
				<div>2. The opening and closing tags of the outermost block elements must not be indented</div>
			</div>

			<div class="help_body_info">
				<div class="html_data_wrap_last_tab">
				<div>&lt;pre&gt;</div>
				 <div>&nbsp;&nbsp;&nbsp;&nbsp;You &lt;em&gt;cannot&lt;/em&gt; use Markdown here</div>
				<div>&lt;/pre&gt;</div>
			</div>
			</div>
		</article>
	</div><!-- .formating_markdown_help_body -->
</section><!-- .formating_markdown_help -->