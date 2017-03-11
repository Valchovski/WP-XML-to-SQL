<?php


class Feed {
    public $AgencyName;
    public $AgencyID;
    public $AgencyTel;
    public $AgencyEmail;
    public $Updated;
    public $Offers;

    function Parse( $data ) {
        $this->AgencyName = isset( $data['AgencyName'] ) ? $data['AgencyName'] : null;
        $this->AgencyID = isset( $data['AgencyID'] ) ? $data['AgencyID'] : null;
        $this->AgencyTel = isset( $data['AgencyTel'] ) ? $data['AgencyTel'] : null;
        $this->AgencyEmail = isset( $data['AgencyEmail'] ) ? $data['AgencyEmail'] : null;
        $this->Updated = isset( $data['Updated'] ) ? $data['Updated'] : null;
        $this->Offers = [];
        if(!isset($data['Offers']))
            return;

        foreach( $data['Offers'] as $o ) {
            $offer = new Offer();
            $offer->Parse( $o );
        }
    }

    function Insert( $db ) {
    }
}

class Offer {
    public $EstateID;
    public $MainType;
    public $SubType;
    public $Status;
    public $Domain;
    public $City;
    public $SubCity;
    public $DealType;
    public $EstateName;
    public $Content;
    public $EstateRefCode;
    public $UpdateDate;
    public $Price;
    public $Currency;
    public $Description;
    public $YoutubeLink;
    public $Tags;
    public $Latitude;
    public $Longtitude;
    public $Zoom;
    public $BrokerID;
    public $BrokerName;
    public $BrokerTel;
    public $BrokerEmail;
    public $BrokerImg;
    public $Images;
    public $Amenities;
    public $Locations; // No info - ignore;
    public $SpecialData;
    public $CreateDate;
    public $OldPrice;
    public $Draws; // no-info - ignore;
    public $Distances; // no-info - ignore

    function Parse($data) {
        // TODO:
        $this->EstateID = isset( $data['EstateID'] ) ? $data['EstateID'] : null;
        $this->MainType = isset( $data['MainType'] ) ? $data['MainType'] : null;
        $this->SubType = isset( $data['SubType'] ) ? $data['SubType'] : null;
        $this->Status = isset( $data['Status'] ) ? $data['Status'] : null;
        $this->Domain = isset( $data['Domain'] ) ? $data['Domain'] : null;
        $this->City = isset( $data['City'] ) ? $data['City'] : null;
        $this->SubCity = isset( $data['SubCity'] ) ? $data['SubCity'] : null;
        $this->DealType = isset( $data['DealType'] ) ? $data['DealType'] : null;
        $this->EstateName = [];
        $this->EstateRefCode = isset( $data['EstateRefCode'] ) ? $data['EstateRefCode'] : null;
        $this->UpdateDate = isset( $data['UpdateDate'] ) ? $data['UpdateDate'] : null;
        $this->Price = isset( $data['Price'] ) ? $data['Price'] : null;
        $this->Currency = isset( $data['Currency'] ) ? $data['Currency'] : null;
        $this->Description = [];
        $this->YoutubeLink = isset( $data['YoutubeLink'] ) ? $data['YoutubeLink'] : null;
        $this->Tags = [];
        $this->Latitude = isset( $data['Latitude'] ) ? $data['Latitude'] : null;
        $this->Longtitude = isset( $data['Longtitude'] ) ? $data['Longtitude'] : null;
        $this->Zoom = isset( $data['Zoom'] ) ? $data['Zoom'] : null;
        $this->BrokerID = isset( $data['BrokerID'] ) ? $data['BrokerID'] : null;
        $this->BrokerName = isset( $data['BrokerName'] ) ? $data['BrokerName'] : null;
        $this->BrokerTel = isset( $data['BrokerTel'] ) ? $data['BrokerTel'] : null;
        $this->BrokerEmail = isset( $data['BrokerEmail'] ) ? $data['BrokerEmail'] : null;
        $this->BrokerImg = isset( $data['EstaBrokerImgteID'] ) ? $data['BrokerImg'] : null;
        $this->Images = isset( $data['Images'] ) ? $data['Images'] : null;
        $this->Amenities = [];
        $this->Locations = isset( $data['Locations'] ) ? $data['Locations'] : null; // no info - ignore
        $this->CreateDate = isset( $data['CreateDate'] ) ? $data['CreateDate'] : null;
        $this->OldPrice = isset( $data['OldPrice'] ) ? $data['OldPrice'] : null;
        $this->Draws = isset( $data['Draws'] ) ? $data['Draws'] : null; // no info - ignore
        $this->Distances = isset( $data['Distances'] ) ? $data['Distances'] : null; // no info - ignore
        $this->SpecialData = [];

        var_dump($data);

        /*foreach( $data['EstateName'] as $en ) {
            $languageText = new LanguageText();
            $languageText->Parse( $en );
        }

        foreach( $data['Description'] as $des ) {
            $languageText = new LanguageText();
            $languageText->Parse( $des );
        }

        foreach( $data['Tags'] as $t ) {
            $tags = new Tags();
            $tags->Parse( $t );
        }*/

        foreach( $data['Amenities'] as $a ) {
            array_push($this->Amenities, $a);
        }
    /*
        foreach( $data['SpecialData'] as $sd ) {
            $specialData = new SpecialData();
            $specialData->Parse( $sd );
        }  
    */
    }

    function Insert( $db ) {
        // Insert this offer as post
        $id = $db->insert_id;
        $this->Tags->Insert( $id, $db );
    }
}

class LanguageText {
    public $lang;
    public $text;

    function Parse( $data ) {
        $this->lang = isset ( $data['lang'] ) ? $data['lang'] : null;
        $this->text = isset ( $data['text'] ) ? $data['text'] : null;

        var_dump($this);
    }
}

class Tags {
    public $Top;
    public $Exclusive;
    public $Nocommission;
    
    function Parse( $data ) {
        $this->Top = isset ( $data['Top'] ) ? $data['Top'] : 0;
        $this->Exclusive = isset ( $data['Exclusive'] ) ? $data['Exclusive'] : 0;
        $this->Nocommission = isset ( $data['Nocommission'] ) ? $data['Nocommission'] : 0;

        var_dump($this);
    }

    function Insert( $oid, $db ) {
        $db->insert( 'postmeta', [ 'post_id' => $pid, 'meta_key' => 'cf47rs_featured', 'meta_value' => $Top ], [ '%d', '%s', '%d' ]  );
        $db->insert( 'postmeta', [ 'post_id' => $pid, 'meta_key' => '_cf47rs_featured', 'meta_value' => 'field_cf47rs_property_featured' ], [ '%d', '%s', '%s' ]  );
    }
}

class SpecialData {
    public $ConstructType;
    public $Area;
    public $Rooms;
    public $Bedrooms;
    public $Floor;
    public $Floors;
    public $Position;
    public $NewBuildID;
    public $Heatings;
    public $Bathrooms;
    public $Stage;

    function Parse( $data ) {
        $this->ConstructType = isset ( $data['ConstructType'] ) ? $data['ConstructType'] : null;
        $this->Area = isset ( $data['Area'] ) ? $data['Area'] : null;
        $this->Rooms = isset ( $data['Rooms'] ) ? $data['Rooms'] : null;
        $this->Bedrooms = isset ( $data['Bedrooms'] ) ? $data['Bedrooms'] : null;
        $this->Floor = isset ( $data['Floor'] ) ? $data['Floor'] : null;
        $this->Floors = isset ( $data['Floors'] ) ? $data['Floors'] : null;
        $this->Position = isset ( $data['Position'] ) ? $data['Position'] : null;
        $this->NewBuildID = isset ( $data['NewBuildID'] ) ? $data['NewBuildID'] : null;
        $this->Heatings = isset ( $data['Heatings'] ) ? $data['Heatings'] : null;
        $this->Bathrooms = isset ( $data['Bathrooms'] ) ? $data['Bathrooms'] : null;
        $this->Stage = isset ( $data['Stage'] ) ? $data['Stage'] : null;

        var_dump($this);
        
    }

    function Insert() {

    }
}