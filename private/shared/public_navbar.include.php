<article class="navbar_art">
    <nav class="top_header_navbar">
        <span>
        	<a href="<?php echo url_for('/'); ?>" class="main_link no_underline home_navbar nav_link_home">Home</a>
        </span>
        <?php 
        if($user_login == true):
         ?>
        <span>
        	<a href="<?php echo url_for('/user/notes'); ?>" class="main_link no_underline notes_navbar nav_link_notes">Notes</a>
        </span>
        <span>
        	<a href="<?php echo url_for('/user/subjects')?>" class="main_link no_underline subjects_navbar nav_link_subjects">Subjects</a>
        </span>
        <span>
        	<a href="<?php echo url_for('/user/topic')?>" class="main_link no_underline topics_navbar nav_link_topics">Topics</a>
        </span>
        <span>
        	<a href="<?php echo url_for('/user/tags')?>" class="main_link no_underline tags_navbar nav_link_tags">Tags</a>
        </span>

        <span class="more_nav_top_links">
        	<span class="click_to_see_top_nav_links"><a href="javascript:void(0)" class="main_link no_underline more_navbar nav_link_more">More <span class="unicode_down_arrow">⇩</span></a></span>
        	<ul class="more_nav_top_ul">
        		<li class="more_nav_top_li"><a href="<?php echo url_for('/user/watch_later')?>" class="no_underline watch_later_navbar nav_link_watch_later">Watch later</a></li>
        		<li class="more_nav_top_li"><a href="<?php echo url_for('/user/important_notes')?>" class="no_underline imp_notes_navbar nav_link_imp_notes">Important notes</a></li>
                <li class="more_nav_top_li"><a href="<?php echo url_for('/user/overview')?>" class="no_underline imp_notes_navbar nav_link_overview">Overview</a></li>
        	</ul><!-- .more_nav_top_ul -->
        </span><!-- .more_nav_top_links -->
    <?php endif; ?>
        <span>
        	<a href="<?php echo url_for('/pages/about')?>" class="main_link no_underline about_navbar nav_link_about">About</a>
        </span>
    </nav>
</article>
