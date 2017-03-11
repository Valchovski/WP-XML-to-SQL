<?php 
    require_once ('model.php');

class Sqlifier {   
    function sqlify( $path ) 
    { 
        global $wpdb;

        $xml = new XMLReader();
        $xml->open($path);
        $assoc = Self::xml2assoc($xml);
        $xml->close();

        if( !isset($assoc['feed']) )
        {
            die(' Invalid XML file submited - missing FEED tag !' );
        }

        $model = new Feed();
        var_dump($assoc['feed']);
        die();
        $model->Parse( $assoc['feed'] );
        
        echo '<pre>';
        print_r($model);
        die('</pre>');
    }

    function xml2assoc($xml) { 
        $tree = null; 
        while($xml->read()) 
            switch ($xml->nodeType) { 
                case XMLReader::END_ELEMENT: return $tree; 
                case XMLReader::ELEMENT: 
                    $name = $xml->name;
                    $node = $xml->isEmptyElement ? '' : Self::xml2assoc($xml); // array('value' => $xml->isEmptyElement ? '' : Self::xml2assoc($xml)); 
                    /*if($xml->hasAttributes) 
                        while($xml->moveToNextAttribute()) 
                            $node['attributes'][$xml->name] = $xml->value; */
                    $tree[$name] = $node; 
                break; 
                case XMLReader::TEXT: 
                case XMLReader::CDATA: 
                    $tree .= $xml->value; 
            } 
        return $tree; 
    }

    function uploadxml($file) {
        $target_dir = plugin_dir_path(__DIR__).'sqlifier/';
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if file already exists
        if (file_exists($target_file)) 
            unlink( $target_file );
        // Allow certain file formats
        if($fileType != "xml") {
            echo "Sorry, only XML files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                $this->sqlify($target_file);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>