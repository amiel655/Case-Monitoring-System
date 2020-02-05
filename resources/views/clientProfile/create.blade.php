@extends('layouts.dashboard')
@section('title', "Client's Profile")
@section('content')
{!!Form::open(['action' => 'FormController@store','method' => 'POST' ])!!}

<div class="header-text-title">
    <h1 class="text-center">INTERVIEW FORM/CLIENT'S PROFILE</h1>
</div>
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-border shadow">
                <div class="row  mr-4 ml-4">
                    <div class="col-md-12 text-center">
                        <br>
                        <h4 class="text-center">Control Referrence</h4>
                        <center>
                            <div class="row">
                                <!-- Region -->
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="region"> Region
                                            {{Form::text('interviewer', '',['class'=>'form-control formStyle no-focus',
                                            'readonly' =>
                                            'true', 'placeholder' => '3'])}}
                                        </label>
                                    </div>
                                </div>
                                <!-- District Office -->
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="region"> District Office
                                            {{Form::text('interviewer', '',['class'=>'form-control formStyle no-focus',
                                            'readonly'
                                            =>
                                            'true', 'placeholder' => 'CSFP'])}}
                                        </label>
                                    </div>
                                </div>
                                <!-- Control Number -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="controlnumber"> Control Number
                                            {{Form::text('controlnumber', '',['class'=>'form-control formStyle
                                            no-focus',
                                            'readonly'
                                            =>
                                            'true', 'placeholder' => '123-456-78'])}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="col-md-12">
                        <!-- Date -->
                        <div class="form-group">
                            <label for="date">Date</label>
                            {{Form::date('date', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Interviewer -->
                        <div class="form-group">
                            <label for="interviewer">Interviewer</label>
                            <br>
                            {{Form::text('interviewer', '',['class'=>'form-control'])}}
                            {{-- <div class="btn-group">
                                <button type="button" class="btn-outline-secondary btn dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Please Choose
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Atty. Arlan Cabuso</a>
                                    <a class="dropdown-item" href="#">Atty. Mar Lapuz</a>
                                    <a class="dropdown-item" href="#">Atty. Aaron Matawaran</a>
                                    <a class="dropdown-item" href="#">Atty. Shernon Severino</a>
                                </div>
                            </div> --}}
                        </div>

                        <!-- Assigned to -->
                        <div class="form-group">
                            <label for="assigned_to">Assigned To</label>
                            <br>
                            {{-- {{Form::text('assigned_to', '',['class'=>'form-control'])}} remove --}}
                            <div class="btn-group">
                                <button type="button" class="btn-outline-secondary btn dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Please Choose
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Atty. Arlan Cabuso</a>
                                    <a class="dropdown-item" href="#">Atty. Mar Lapuz</a>
                                    <a class="dropdown-item" href="#">Atty. Aaron Matawaran</a>
                                    <a class="dropdown-item" href="#">Atty. Shernon Severino</a>
                                </div>
                            </div>
                        </div>

                        <!-- Referred/Indorsed by -->
                        <div class="form-group">
                            <label for="referred_by">Referred/Indorsed By</label>
                            <br>
                            {{Form::text('referred_by', '',['class'=>'form-control'])}}
                            {{-- <div class="btn-group">
                                <button type="button" class="btn-outline-secondary btn dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Please Choose
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Atty. Arlan Cabuso</a>
                                    <a class="dropdown-item" href="#">Atty. Mar Lapuz</a>
                                    <a class="dropdown-item" href="#">Atty. Aaron Matawaran</a>
                                    <a class="dropdown-item" href="#">Atty. Shernon Severino</a>
                                </div>
                            </div> --}}
                        </div>

                        <!-- Refer to -->
                        <div class="form-group">
                            <label for="refer_to">Refer To</label>
                            <br>
                            {{-- {{Form::text('refer_to', '',['class'=>'form-control'])}} remove --}}
                            <div class="btn-group">
                                <button type="button" class="btn-outline-secondary btn dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Please Choose
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Atty. Arlan Cabuso</a>
                                    <a class="dropdown-item" href="#">Atty. Mar Lapuz</a>
                                    <a class="dropdown-item" href="#">Atty. Aaron Matawaran</a>
                                    <a class="dropdown-item" href="#">Atty. Shernon Severino</a>
                                </div>
                            </div>
                        </div>

                        <!-- Approved By -->
                        <div class="form-group">
                            <label for="approved_by">Approved By</label>
                            <br>
                            {{Form::text('approved_by', '',['class'=>'form-control'])}}
                            {{-- <div class="btn-group">
                                <button type="button" class="btn-outline-secondary btn dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Please Choose
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Atty. Arlan Cabuso</a>
                                    <a class="dropdown-item" href="#">Atty. Mar Lapuz</a>
                                    <a class="dropdown-item" href="#">Atty. Aaron Matawaran</a>
                                    <a class="dropdown-item" href="#">Atty. Shernon Severino</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nature of Request -->
        <div class="col-md-6">
            <div class="card card-border shadow">
                <div class="row mr-4 ml-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <br>
                            <h4 class="text-center">Nature of Request</h4>
                            <br>
                            {{-- {{Form::text('nature_request', '',['class'=>'form-control'])}}
                            Change value to radio button khel shernon --}}
                            {{-- Radio Buttons --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradio">Legal Advice
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12"><br>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradio">Legal
                                            Documentation
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12"><br>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradio">Representation
                                            in court/quasi-judicial bodies
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12"><br>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradio">Inquest/Legal
                                            Assistance
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12"><br>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradio">Mediation/Concillation
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12"><br>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradio">Administration
                                            of oath
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <div class="col-md-12 mt-3 text-center">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="text" class="form-control underline-one" name="optradio">
                                                    <p class="text-center">Others</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client's Profile -->
        <!-- Name -->
        <div class="col-md-12 mt-3">
            <div class="card card-border shadow">
                <div class="row mr-4 ml-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <br>
                            <h4 class="text-center">Client's Personal Circumtances</h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <br>
                            <label for="name">Name</label>
                            {{Form::text('name', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Religion -->
                        <div class="form-group space-top">
                            <label for="religion">Religion</label>
                            {{Form::text('religion', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Citizenship -->
                        <div class="form-group">
                            <label for="citizenship">Citizenship</label>
                            {{Form::text('citizenship', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="address">Address</label>
                            {{Form::text('address', '',['class'=>'form-control'])}}
                        </div>

                        <!-- E-mail -->
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            {{Form::text('email', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Individual Monthly Net Income -->
                        <div class="form-group">
                            <label for="monthly_net_income">Individual Monthly Net Income</label>
                            {{Form::text('monthly_net_income', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Detained -->
                        <div class="form-group">
                            <label for="detained">Detained</label>
                            {{-- {{Form::text('detained', '',['class'=>'form-control'])}}
                            Change value to radio button khel shernon --}}
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradio">Yes
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradio">No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detained Since -->
                        <div class="form-group" style="margin-top: 30px;">
                            <label for="detained_since">Detained Since</label>
                            {{Form::date('detained_since', '',['class'=>'form-control'])}}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <br>
                        <!-- Age -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    {{Form::number('age', '',['class'=>'form-control'])}}
                                </div>
                            </div>
                            <!-- Gender -->
                            <div class="col-md-4 mt">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    {{-- {{Form::text('gender', '',['class'=>'form-control'])}} remove --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="optradio">Male
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="optradio">Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Civil Status -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="civil_status">Civil Status</label>
                                    {{-- {{Form::text('civil_status', '',['class'=>'form-control'])}} remove --}}
                                    <div class="btn-group">
                                        <button type="button" class="btn-outline-secondary btn dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Choose
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Married</a>
                                            <a class="dropdown-item" href="#">Widowed</a>
                                            <a class="dropdown-item" href="#">Separated</a>
                                            <a class="dropdown-item" href="#">Divorced</a>
                                            <a class="dropdown-item" href="#">Single</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Educational Attainment -->
                        <div class="form-group">
                            <label for="educational_attainment">Educational Attainment</label>
                            {{Form::text('educational_attainment', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Language/Dialect -->
                        <div class="form-group">
                            <label for="language">Language/Dialect</label>
                            {{Form::text('language', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Contact No. -->
                        <div class="form-group">
                            <label for="contact">Contact No.</label>
                            {{Form::number('contact', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Spouse -->
                        <div class="form-group">
                            <label for="spouse">Spouse</label>
                            {{Form::text('spouse', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Address of Spouse -->
                        <div class="form-group">
                            <label for="spouse_address">Address of Spouse</label>
                            {{Form::text('spouse_address', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Contact No. of Spouse -->
                        <div class="form-group">
                            <label for="spouse_contact">Contact No. of Spouse</label>
                            {{Form::text('spouse_contact', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Place of Detention -->
                        <div class="form-group">
                            <label for="detention_place">Place of Detention</label>
                            {{Form::text('detention_place', '',['class'=>'form-control'])}}
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="card card-border shadow">
                <div class="row  mr-4 ml-4">
                    <div class="col-md-12 text-center">
                        <br>
                        <h4 class="text-center">Interviewee's Personal Circumtances</h4>
                    </div>
                    <div class="col-md-12">
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name_interviewee">Name</label>
                            {{Form::text('name_interviewee', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="address_interviewee">Address</label>
                            {{Form::text('address_interviewee', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Relationship to Client -->
                        <div class="form-group">
                            <label for="relationship_to_client_interviewee">Relationship to Client</label>
                            {{Form::text('relationship_to_client_interviewee', '',['class'=>'form-control'])}}
                        </div>

                        <!-- Age -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    {{Form::number('age', '',['class'=>'form-control'])}}
                                </div>
                            </div>
                            <!-- Gender -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    {{-- {{Form::text('gender', '',['class'=>'form-control'])}} remove --}}

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="optradio">Male
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="optradio">Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Civil Status -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="civil_status">Civil Status</label>
                                    {{-- {{Form::text('civil_status', '',['class'=>'form-control'])}} remove --}}
                                    <div class="btn-group">
                                        <button type="button" class="btn-outline-secondary btn dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Choose
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Married</a>
                                            <a class="dropdown-item" href="#">Widowed</a>
                                            <a class="dropdown-item" href="#">Separated</a>
                                            <a class="dropdown-item" href="#">Divorced</a>
                                            <a class="dropdown-item" href="#">Single</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Number -->
                        <div class="form-group">
                            <label for="contact_number_interviewee">Contact Number</label>
                            {{Form::number('contact_number_interviewee', '',['class'=>'form-control'])}}
                        </div>

                        <!-- E-mail -->
                        <div class="form-group">
                            <label for="email_interviewee">E-mail</label>
                            {{Form::text('email_interviewee', '',['class'=>'form-control'])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="card card-border shadow">
                <div class="row  mr-4 ml-4">
                    <div class="col-md-12 text-center">
                        <br>
                        <h4 class="text-center">I. Nature of the Case</h4>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio">Criminal
                                        <br>
                                        <input type="text" class="form-control" placeholder="Pls Specify">
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12"><br>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio">Administrative
                                        <br>
                                        <input type="text" class="form-control" placeholder="Pls Specify">
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12"><br>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio">Civil
                                        <br>
                                        <input type="text" class="form-control" placeholder="Pls Specify">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio">Appeal
                                        <br>
                                        <input type="text" class="form-control" placeholder="Pls Specify">
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12"><br>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio">Labor
                                        <br>
                                        <input type="text" class="form-control" placeholder="Pls Specify">
                                    </label>
                                </div><br>
                            </div>
                        </div>
                    </div><br>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card card-border shadow">
                <div class="row  mr-4 ml-4">
                    <div class="col-md-12 text-center">
                        <br>
                        <h4 class="text-center">IIA. Client's Case Involvement</h4>
                    </div>
                    <div class="row mt-3 ml-5 text-left">
                        <div class="col-md-3">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">Plaintiff
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">Petitioner
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">Defendent
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">Respondent
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">Oppositor
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">Accused
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">Others
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <label class="form-check-label">
                                    Compliant/Victim of:
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <span class="mr-4">a) </span> <input type="radio" class="form-check-input" name="optradio">
                                    R.A 9262 (VAWC)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <span class="mr-4">c) </span> <input type="radio" class="form-check-input" name="optradio">
                                    R.A 9745 (Anti-Torture Law)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <span class="mr-4">e) </span> <input type="radio" class="form-check-input" name="optradio">
                                    Agrarian Case
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <span class="mr-4">b) </span> <input type="radio" class="form-check-input" name="optradio">
                                    R.A 9372 (Human Security Act)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <span class="mr-4">d) </span> <input type="radio" class="form-check-input" name="optradio">
                                    R.A 9344 (CICL)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <span class="mr-4">f) </span> <input type="radio" class="form-check-input" name="optradio">
                                    Others
                                </label>
                            </div>
                        </div>
                    </div>
                </div><br>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card card-border shadow">
                <div class="row  mr-4 ml-5">
                    <div class="col-md-12 text-center">
                        <br>
                        <h4 class="text-center">IIB. Client's Classification</h4>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Children in Conflict with the Law
                                <br>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="number" class="form-control" placeholder="Age">
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Women Client
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Indigenous Group
                                <br>
                                <input type="text" class="form-control" placeholder="Please Specify">
                            </label>
                        </div>
                        <br>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Person with Disablity (PWD)
                                <br>
                                <input type="text" class="form-control" placeholder="Type of Disability">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Urban Poor
                                <br>
                                <input type="text" class="form-control" placeholder="Please Specify">
                            </label>
                        </div>
                        <br>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Rural Poor
                                <br>
                                <input type="text" class="form-control" placeholder="Please Specify">
                            </label>
                        </div>
                        <br>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Refugees/Evacuees
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Senior Citizen
                            </label>
                        </div>
                        <div class="form-check">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradio">
                                            OFW
                                        </label>
                                        <br>
                                        <label class="form-check-label">
                                            <span class="mr-4">a) </span> <input type="radio" class="form-check-input"
                                                name="optradio">
                                            Land-based
                                        </label>
                                        <label class="form-check-label">
                                            <span class="mr-4">c) </span> <input type="radio" class="form-check-input"
                                                name="optradio">
                                            Sea-based
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="card card-border shadow">
                <div class="row  mr-4 ml-3">
                    <div class="col-md-12 text-center">
                        <br>
                        <h4 class="text-center">III. Adverse Party</h4>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Plainfill/Petitioner/Complainant
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Defendant/Respondent/Accused
                            </label>
                        </div>
                        <br>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="text" class="form-control" placeholder="Name">
                            </label>
                        </div>
                        <br>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Oppositor/Others
                            </label>
                        </div>
                        <br>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="text" class="form-control" placeholder="Address">
                            </label>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card card-border shadow">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <br>
                        <h4 class="text-center">IV. Fact of the Case</h4>
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <form>
                        <div class="form-group">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="9" width="100" height="100"></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card card-border shadow">
                <div class="row">
                    <div class="col-md-12 text-center pl-3 pr-3">
                        <br>
                        <h4 class="text-center">V. Cause of Acion/Nature of Offense</h4>
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <form>
                        <div class="form-group">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="6" width="100" height="100"></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card card-border shadow">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <br>
                        <h4 class="text-center">VI. Pending in Court? </h4>
                        <div class="row pl-5 pr-5">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio">Yes
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio">No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <!-- Title of the Case abd Docket No -->
                    <div class="form-group">
                        <label for="title_of_the_case_and_docket_no">Title of the Case abd Docket No: </label>
                        {{Form::text('title_of_the_case_and_docket_no', '',['class'=>'form-control'])}}
                    </div>
                </div>
                <div class="col-md-12">
                    <!-- Court/Body/Tribunal -->
                    <div class="form-group">
                        <label for="court_body_tribunal">Court/Body/Tribunal: </label>
                        {{Form::text('court_body_tribunal', '',['class'=>'form-control'])}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card card-border shadow">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <br>
                        <h4 class="text-center">VII. Other Related Pending/Concluded Case(s)</h4>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="col-md-12">
                        <!-- Case of Action/Nature of Offense -->
                        <div class="form-group">
                            <label for="case_of_action_and_nature_of_offense">Case of Action/Nature of Offense: </label>
                            {{Form::text('case_of_action_and_nature_of_offense', '',['class'=>'form-control'])}}
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <!-- Court/Body/Tribunal -->
                        <div class="form-group">
                            <label for="court_body_tribunal">Court/Body/Tribunal: </label>
                            {{Form::text('court_body_tribunal', '',['class'=>'form-control'])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card card-border shadow">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <br>
                        <h4 class="text-center">Proof of Indigency Submitted</h4>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Income Tax Return
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Certification from Barangay
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Certification (DSWD)
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio">
                                Others (payslip, etc.)
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 text-right pr-5">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="text" class="form-control underline-one" name="optradio">
                                <p class="text-center">Party/Representative</p>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card card-border shadow">
                <div class="row">
                    <div class="col-md-4 mt-5">
                        <div class="form-check">
                            <label class="form-check-label d-inline">
                                Republic of the Philippines)
                                <input type="text" class="form-control underline d-inline">) S.s.
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <h4 class="text-center">AFFIDAVIT OF INDIGENCY</h4>
                        <br>
                        <div class="text-center">
                            I, <input type="text" class="form-control underline-two d-inline"> of legal age, &nbsp;
                            <div class="form-check d-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">
                                    single
                                </label>
                            </div>
                            <div class="form-check d-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">
                                    married: to
                                </label>
                            </div>
                            <input type="text" class="form-control underline-two d-inline">
                            <div class="form-check d-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">
                                    widow
                                </label>
                            </div> &nbsp;
                            <div class="form-check d-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio">
                                    widower
                                </label>
                                and residing at
                            </div>
                            <input type="text" class="form-control underline-two d-inline">
                            and having been duly sworn in accord-<br>
                            <p class="text-left pl-5 ml-5"><span class="pl-5">ance with the law, depose and say:</span></p>

                            <div class="text-left pl-5 ml-5">
                                <span class="pl-5 ml-5">1. That I desire to avail the free legal service of the Public
                                    Attorney's Office;</span><br><br>
                                <span class="pl-5 ml-5">2. That my monthly salary/income is &#8369; <input type="number"
                                        class="form-control underline-three d-inline no-focus">;</span><br><br>
                                <span class="pl-5 ml-5">3. That I am executing this affidavit to entitle me to the
                                    desired legal services.</span><br><br>
                            </div>

                            <div class="text-left pl-5 ml-5">
                                <span class="pl-5 ml-5">IN WITNESS WHEREOF, I have hereunto affixed my signature this
                                    <input type="text" class="form-control underline-four d-inline"> day of <br>&nbsp;
                                    <input type="number" class="form-control underline-four d-inline no-focus">20<input
                                        type="number" class="form-control underline-four d-inline no-focus"> in
                                    <input type="text" class="form-control underline-two d-inline">, Philippines.</span>
                            </div>

                            <div class="col-md-12 mt-3 text-right pr-5">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="text" class="form-control underline-one" name="optradio">
                                        <p class="text-center">Signature of Affiant</p>
                                    </label>
                                </div>
                            </div>

                            <div class="text-left pl-5 ml-5">
                                <span class="pl-5 ml-5">SUBSCRIBED AND SWORN to before me this
                                    <input type="text" class="form-control underline-four d-inline"> day of &nbsp;
                                    <input type="number" class="form-control underline-four d-inline no-focus">20<input
                                        type="number" class="form-control underline-four d-inline no-focus"> in
                                    <input type="text" class="form-control underline-two d-inline">, Philippines, and I
                                    have read and
                                    translated <br> foregoing Affidavit to a dialect understood by the affiant.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center mt-3">
                        {{Form::Submit('Submit', ['class'=>'btn btn-success'])}}
                        {!! Form::close() !!}
                    </div>
                </div><br>
            </div>
        </div>
        <br>

        @endsection
