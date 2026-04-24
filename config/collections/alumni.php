<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'alumni',
    'fullname' => 'University of Edinburgh Historical Alumni',
    'theme' => 'alumni',
    'url_prefix' => 'alumni',

    'adminemail' => 'HeritageCollections@ed.ac.uk',

    'container_id' => env('ALUMNI_CONTAINER_ID', '8f5e9ab3-98cb-4665-b911-4507a72bb788'),
    // Alumni indexes by community, not collection (matches legacy CI site).
    'container_field' => 'location.comm',

    'field_mappings' => [
        'Name' => 'dc.contributor.author.en',
        'Title' => 'dc.title.en',
        'Bitstream'=> 'dc.format.original.en',
        'Thumbnail'=> 'dc.format.thumbnail.en',
        'Description'=>'dc.description.en',
    //    'Year'=> 'dc.date.issued',
        'Birthplace' => 'dc.contributor.authorplace.en',
        'Previous School Education' => 'dc.description.schoolprev.en',
        'Matriculation Number' => 'dc.identifier.matric',
        'Gender' => 'dc.contributor.authorgender.en',
        'Age' => 'dc.contributor.authorage',
        'Faculty' => 'dc.description.faculty.en',
        'Nationality' => 'dc.contributor.authorcountry.en',
        'Year'=>'dc.coverage.temporal.en',
        'Collection'=>'dc.relation.ispartof.en',
        'Date of award'=>'dc.coverage.temporalaward.en',
        'Award'=>'dc.description.award.en',
        'Source information'=>'dc.description.source.en',
        'Notes'=>'dc.description.noqual.en',
        'Previous medical education'=>'dc.description.medprev.en',
        'Previous University education'=>'dc.description.univprev.en',
        'Address'=>'dc.description.address.en',
        'Thesis'=>'dc.description.thesis.en',
        'Salutation'=>'dc.contributor.authortitle.en',
        'Apprentice of Royal College of Surgeons'=>'dc.coverage.temporalarcs.en',
        'Diplomate of Royal College of Surgeons'=>'dc.coverage.temporaldrcs.en',
        'Fellow of Royal College of Surgeons'=>'dc.coverage.temporalfrcs.en',
        'Indian Medical Service'=>'dc.coverage.temporalims.en',
        'MD (Edin)'=>'dc.coverage.temporalmdedin.en',
        'British Navy'=>'dc.coverage.temporalnavy.en',
        'Royal Army Medical Corps'=>'dc.coverage.temporalramc.en',
        'Royal Medical Society'=>'dc.coverage.temporalrms.en',
        'Span of study'=>'dc.coverage.temporalstudyspan.en',
        'First year of study'=>'dc.coverage.temporalyear1.en',
        'Year 2'=>'dc.coverage.temporalyear2.en',
        'Year 3'=>'dc.coverage.temporalyear3.en',
        'Year 4'=>'dc.coverage.temporalyear4.en',
        'Year 5'=>'dc.coverage.temporalyear5.en',
        'Year 6'=>'dc.coverage.temporalyear6.en',
        'Year 7'=>'dc.coverage.temporalyear7.en',
        'Date of enrolment'=>'dc.date.enrolled.en',
        'Class'=>'dc.description.class.en',
        'Additional information'=>'dc.description.other.en',
        'Register no'=>'dc.identifier.register.en',
        'Annals'=>'dc.relation.ispartofannals.en',
        'Robb'=>'dc.relation.ispartofrobb.en',
        'Watt'=>'dc.relation.ispartofwatt.en',
        'Destination after study'=>'dc.coverage.spatial.en',
        'Subject'=>'dc.subject.en',
        'Date of birth'=>'dc.coverage.temporalbirth.en',
        'Date of death'=>'dc.coverage.temporaldeath.en'
    ],


// Static pages for collections- deal with this stuff
/*
$config['skylight_static_pages'] = array('Students of Medicine, 1762-1826'=>'rosner',
    'First Matriculations, 1890-1899'=>'firstmat',
    'Students at New College, 1843-1943'=>'newcoll',
    'Extra Academical students, 1887-1922'=>'extraac',
    'Graduates in Veterinary Medicine, 1911-1955'=>'vetgrad',
    'Students of Medicine (sample of 205), 1833-1846'=>'medsample',
    'Awards to Women students, 1876-1894'=>'women',
    'Early Veterinary Graduates, 1825-1865'=>'earlyvet',
    'Female Medical Graduates 1896-1900'=>'femalegrad',
    'University of Edinburgh: Roll of Honour, WW1'=>'ww1roll'
    )
;
*/

    'recorddisplay' => [
        'Subject',
        'Description',
        'Birthplace',
        'Previous School Education',
        'Matriculation Number',
        'Gender',
        'Age',
        'Faculty',
        'Nationality',
        'First year of study',
        'Collection',
        'Date of award',
        'Award',
        'Source information',
        'Notes',
        'Previous medical education',
        'Previous University education',
        'Address',
        'Thesis',
        'Salutation',
        'Apprentice of Royal College of Surgeons',
        'Diplomate of Royal Colleg of Surgeons',
        'Fellow of Royal College of Surgeons',
        'Indian Medical Service',
        'MD (Edin)',
        'British Navy',
        'Royal Army Medical Corps',
        'Royal Medical Society',
        'Span of study',
        'Year 2',
        'Year 3',
        'Year 4',
        'Year 5',
        'Year 6',
        'Year 7',
        'Date of enrolment',
        'Class',
        'Additional information',
        'Register no',
        'Annals',
        'Robb',
        'Watt',
        'Destination after study',
        'Date of birth',
        'Date of death',
    ],

    'searchresult_display' => [
        'Title',
        'Subject',
        'Type',
        'Bitstream',
        'Thumbnail',
        'Year',
        'Collection',
    ],

    'search_fields' => [
        'Collection' => 'dc.collection.en',
        'Year' => 'dc.coverage.temporal.en',
    ],

    'filters' => [
       'Collection' => 'collection_filter',
        'Year' => 'datetemporal_filter',
    ],

    'sort_fields' => [
        'Surname' => 'dc.title_sort',
    ],

    'default_sort' => 'dc.title_sort+asc',

    'related_fields' => [
        'Subject' => 'dc.subject.en',
        'Title' => 'dc.title.en'
    ],
    'related_number' => 10,

    'meta_fields' => [
        'Title' => 'dc.title',
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Subject' => 'Subject',
        'Identifier' => 'Identifier',
    ],

    'results_per_page' => 10,

    'highlight_fields' => 'dc.title.en,dc.subject.en,dc.description.en',

    'oaipmhcollection' => 'hdl_10683_47417',

    'ga_code' => env('ALUMNI_GA_CODE', 'G-Z0TNYYK5EM'),
]);
