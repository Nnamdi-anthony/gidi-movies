<form action="options.php" method="post">
    <?php
    // output security fields for the registered setting "gidi_movies_api"
    settings_fields('gidi_movies_settings_group');
        // output setting sections and their fields
        // (sections are registered for "gidi_movies_api", each field is registered to a specific section)
    do_settings_sections('gidi_movies_settings_group');
        // output save settings button
    submit_button('Update Movies Settings');
    ?>
</form>