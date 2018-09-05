<?php

/*
 * Plugin Name: Media Unzipper
 */

// Prevent direct access to this file
// code

class MediaUnzip
{
    /*
     *  Constructor to initialize objects
     */
    function __construct()
    {
        //initialization code if any
    }

    /*
     *  Add administrative menu for the Plugin
     */
    function add_admin_menu()
    {
        add_menu_page(
            'Upload Media Zip',
            'Upload Media Zip',
            'manage_options',
            'upload_media_zips',
             array($this,'upload_media_zips'),
            'dashicons-media-default',
            35 );
    }

    /*
     *  Utility function to check if a file type is a valid archive
     */
    function allowed_file_types($filetype)
    {
        // Array of allowed file types by MIME
        $allowed_file_types = array('image/png','image/jpeg','image/jpg','image/gif');
        if(in_array($filetype,$allowed_file_types))
        {
            return true;
        } else {
            return false;
        }
    }

    /*
     *  Upload the Zip file and decompress it to the WP media library
     */
    function upload_media_zips()
    {
        echo "<h3>Upload a Media Zip</h3>";

        //If a zip has been selected
        if(isset($_FILES['fileToUpload'])) {

            // Prepare the files to be uploaded to the server.
            // Get the current uploads directory including the year and month.
            $dir 			= "../wp-content/uploads" . wp_upload_dir()['subdir'];

            // Use regular PHP to upload the zip file to the uploads directory (using the $dir variable from above).
            $target_file 	= $dir . '/' . basename($_FILES["fileToUpload"]["name"]);
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            $file_name 		= basename( $_FILES["fileToUpload"]["name"]);

            // Create (instantiate) a new zip utility object.
            $zip 			= new ZipArchive;

            // Attempt to open the zip file.
            $res 			= $zip->open($target_file);

            // Process the zip file if it can be opened.
            if ($res === TRUE)
            {
                $this->process_zip_file($zip, $dir, $file_name);
            }
            else
            {
                echo "<h3 style='color:#F00;'>The zip file was NOT successfully unzipped.</h3>";
            }

            $zip->close();
        }

        echo ('
        <form style="margin-top:20px;" method="post" action="/wordpress/wp-admin/admin.php?page=upload_media_zips"
      enctype="multipart/form-data" class="server-form">
    Select ZIP File: <input type="file" name="fileToUpload" id="fileToUpload">
    <div style="" class="submit-button-section">
        <input style="opacity:1;" type="submit" class="deploy-buttons" value="Upload ZIP File" name="submit">
    </div>
    </form>
        ');
    }

    /*
     *  Do the actual Zip extraction and add them to the media library
     */
    function process_zip_file($zip, $dir, $file_name)
    {
        $zip->extractTo($dir);

        echo "<h3 style='color:#090;'>The zip file $file_name was successfully unzipped to  " . wp_upload_dir()['url'] . ".</h3>";

        // Display a message with the number of media files in the zip file.
        echo "There are ".$zip->numFiles." files in this zip file. <br/>";

        // Loop through each media file to process it for the media library.
        for($i=0; $i < $zip->numFiles; $i++) {

            // Get the URL of the media file.
            $media_file_name = wp_upload_dir()['url'] . '/' . $zip->getNameIndex($i);

            // Get the file type of the media file.
            $filetype 	= wp_check_filetype( basename( $media_file_name ), null );
            $allowed 	= $this->allowed_file_types($filetype['type']);

            if($allowed) {
                // Display a link for the user to view the file on upload...
                echo '<a href="'.$media_file_name.'" target="_blank">' . $media_file_name . '</a> Type: '.$filetype['type'].'<br/>';

                // Prepare the attachment information array that will be used by the media library.
                $attachment = array(
                    'guid'           => $media_file_name,
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', $zip->getNameIndex($i) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );

                // Insert the attachment.
                $attach_id = wp_insert_attachment( $attachment, $dir . '/' . $zip->getNameIndex($i) );

                // Generate the metadata for the attachment.
                $attach_data = wp_generate_attachment_metadata( $attach_id, $dir . '/' . $zip->getNameIndex($i ));
                wp_update_attachment_metadata( $attach_id, $attach_data );

            }
            else
            {
                echo $zip->getNameIndex($i) . ' could not be uploaded. Its file type of ' . $filetype['type'] . ' is now allowed.<br/>' ;
            }
        }
    }
}

//initialize object reference if class exists
if (class_exists('MediaUnzip')) {
    $mediaUnzipRef = new MediaUnzip();
}

//add a menu in the WordPress admin panel
add_action('admin_menu', array($mediaUnzipRef,'add_admin_menu'));