<form action="options.php" method="post">
    <?php
    // output security fields for the registered setting "gidi_movies_api"
    settings_fields('gidi_movies_settings_group_page_templates');
        // output setting sections and their fields
        // (sections are registered for "gidi_movies_api", each field is registered to a specific section)
    do_settings_sections('gidi_movies_settings_group_page_templates');
        // output save settings button
    submit_button('Save Page Templates');
    ?>
</form>