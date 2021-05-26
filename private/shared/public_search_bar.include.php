<section class="search_section">
    <div class="search_input_wrap">
        <?php 
        if($session->is_logged_in()):
         ?>
        <div class="search_options_wrap">
            <select name="search_options" class="search_options_sel">
                <option value="your post" title="Search for your notes" selected>Your post</option>
                <option value="global" title="Search for other notes">Global</option>
            </select>
        </div>
    <?php endif; ?>
        <div class="input_search_close_wrap">
        <input type="search" class="search_top_header" placeholder="Search topics">
        </div>
    </div> <!-- .search_input_wrap -->   
</section><!-- .search_section  -->
