@extends('layouts.app')

@section('content')
@php
    $countryArray=["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","North Korea","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Barthelemy","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Martin","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","Sudan","Suriname","Svalbard and Jan Mayen","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe"];
    $genderArray=['Male','Female'];
@endphp
<div class="container" style="padding: 3%">
    <form class="row g-3" action="{{route('profile.update')}}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label for="inputName" class="form-label">Name</label>
            <input type="text" name='name'class="form-control" id="inputName" value="{{$user->name}}">
        </div>

        <div class="col-md-4">
            <label for="inputGender" class="form-label">Gender</label>
            <select name='gender' id="inputGender" class="form-select">
                @foreach ($genderArray as $item)
                <option  value="{{$item}}" {{($user->profile->gender == $item) ? 'selected' : ''}}>{{$item}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="inputCountry" class="form-label">Country</label>
            <select name='country' id="inputCountry" class="form-select">
                @foreach ($countryArray as $item)
                <option  value="{{$item}}" {{($user->profile->country==$item)?'selected':''}}>{{$item}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="inputAge" class="form-label">Age</label>
            <input type="number" name='age'class="form-control" id="inputAge" min="15" max="80" value="{{$user->profile->age}}">
        </div>
        <div>
            <label for="inputBio" class="form-label">Bio</label>
            <textarea id="inputBio" class="form-control" name='bio' rows="5">{{$user->profile->bio}}</textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">UPDATE</button>
        </div>
    </form>
    <br>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $item )
                <li>{{$item}}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
