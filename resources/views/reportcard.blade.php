@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
    </div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" align='center'>
        <h1>ABCD NUR &amp PRI SCHOOL</h1>
        <p>Seeta, Mukono Uganda<br>Tel: 0703892783, 0755473844 <br> <b>TERMINAL REPORT</b> </p>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
</div>
<div class="row">
        <table class="table">
            <tr>
                <th> <b>PUPIL'S NAME:</b> <span style="color:red" >Mukasa mawuya</span> </th>
                <th>CLASS: <span style="color:red">P.4</span> </th>
                <th>Third Term - 2023</th>
            </tr>
        </table>
        <table class="table table-hover">
            <tr>
                <th>SUBJECT</th>
                <th>AGGREGATES</th>
                <th>REMARKS</th>
                <th>TEACHER</th>
            </tr>
            <tr>
                <th>Science</th>
                <td>3</td>
                <td>Good</td>
                <td>Membe Kenneth</td>
            </tr>
            <tr>
                <th>Math</th>
                <td>2</td>
                <td>Nice</td>
                <td>Muwogo Ian</td>
            </tr>
            <tr>
                <th>English</th>
                <td>1</td>
                <td>Excellent</td>
                <td>Lubowa Stewart</td>
            </tr>
            <tr>
                <th>Social studies</th>
                <td>4</td>
                <td>Fair</td>
                <td>Kamwa Edwin</td>
            </tr>
            <tr>
                <th>Total</th>
                <th>10</th>

        </table>

        <p><b>Headteacher's comment: </b>Rskiigi sjdi fjdk skhd kvod ngkls dhioa dlf ks dflsd fals dfjksd flsdlkfaksd flsd fjks dle sosdkj alsd lsdkf ls  dkjfksdjf ls
                skdjkfljskld jfkd lskd fjls dflkjs dlfj aklsdjflaj sdkljfkla slkdfasdjfke sld fldf slkdfjiv nld fjlsjdf lsjdkfjek sldjf sldf
            dlfjl sdkfjlsj dflsd kfls</p>
        <p><b>Classteacher's comment: </b>Rskiigi sjdi fjdk skhd kvod ngkls dhioa dlf ks dflsd fals dfjksd flsdlkfaksd flsd fjks dle sosdkj alsd lsdkf ls  dkjfksdjf ls
                skdjkfljskld jfkd lskd fjls dflkjs dlfj aklsdjflaj sdkljfkla slkdfasdjfke sld fldf slkdfjiv nld fjlsjdf lsjdkfjek sldjf sldf
            dlfjl sdkfjlsj dflsd kfls</p>

            <table class="table">
                <tr>
                    <th>Next term begins on: <u>23 / 02 / 2023</u></th>
                    <th>SchoolFees: <span style="color:red">Shs.53,000</span></th>
                </tr>
            </table>
            <table class="table table-striped">
                <caption>Other requirements</caption>
                <tr>
                    <th>Brooms</th>
                    <td>3</td>
                </tr>
                <tr>
                    <th>Toilet paper</th>
                    <td>2</td>
                </tr>
                <tr>
                    <th>Rim</th>
                    <td>1</td>
                </tr>
                <tr>
                    <th>Study tour</th>
                    <td>43,000</td>
                </tr>
            </table>
</div>

@endsection
