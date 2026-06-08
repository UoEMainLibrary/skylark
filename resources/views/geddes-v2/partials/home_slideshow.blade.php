@php
    $slideshowImages = [
        'https://cantaloupe.is.ed.ac.uk/iiif/2/T_GED_22_1_510.jpg/329,983,3010,1331/1074,/0/default.jpg',
        'https://images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~57156~105291/257,922,7056,3119/1074,/0/default.jpg',
        'https://cantaloupe.is.ed.ac.uk/iiif/2/T_GED_22_3_27_2.jpg/465,892,3484,1540/1074,/0/default.jpg',
        'https://images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~57067~105284/1008,795,5892,2603/1074,/0/default.jpg',
        'https://images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~54841~105102/371,5399,4280,1891/1074,/0/default.jpg',
        'https://cantaloupe.is.ed.ac.uk/iiif/2/T_GED_22_1_518_4.jpg/76,191,1341,592/1074,/0/default.jpg',
        'https://images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~58042~105341/98,1735,4348,1921/1074,/0/default.jpg',
        'https://images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~54966~105112/1151,1311,6076,2673/1074,/0/default.jpg',
        'https://images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~163815~370549/3461,421,14385,6350/1074,/0/default.jpg',
        'https://cantaloupe.is.ed.ac.uk/iiif/2/T_GED_22_1_475.jpg/163,473,1813,802/1074,/0/default.jpg',
        'https://images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~163753~370475/0,1981,8084,3577/1074,/0/default.jpg',
        'https://cantaloupe.is.ed.ac.uk/iiif/2/T_GED_22_3_11.jpg/203,1122,2570,1133/1074,/0/default.jpg',
    ];
@endphp

<div id="geddes-cf" class="mb-6" aria-hidden="true">
    @foreach($slideshowImages as $image)
        <img src="{{ $image }}" alt="" loading="lazy" decoding="async">
    @endforeach
</div>
