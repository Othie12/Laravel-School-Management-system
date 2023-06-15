@extends('layouts.app')

@section('content')
<x-guest-layout>
    <form method="POST" action="{{ route('grading.create') }}">
        @csrf

<table class="table table-hover table-striped" >
    <h2>SET GRADING</h2>
    <tr>
        <th>Marks</th>
        <th>Aggreegate</th>
        <th>Comment</th>
    </tr>
    <tr>
        <td>0-24</td>
        <td><select name="agg[]" id="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark1" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>25-29</td>
        <td><select name="agg[]" id="2" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark2" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>30-34</td>
        <td><select name="agg[]" id="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>35-39</td>
        <td><select name="agg[]" id="4" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark4" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>40-44</td>
        <td><select name="agg[]" id="5" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark5" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>45-49</td>
        <td><select name="agg[]" id="6" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark6" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>50-54</td>
        <td><select name="agg[]" id="7" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark7" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>55-59</td>
        <td><select name="agg[]" id="8" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark8" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>60-64</td>
        <td><select name="agg[]" id="9" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark9" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>65-69</td>
        <td><select name="agg[]" id="10" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark10" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>70-74</td>
        <td><select name="agg[]" id="11" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark11" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>75-79</td>
        <td><select name="agg[]" id="12" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark12" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>80-84</td>
        <td><select name="agg[]" id="13" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark13" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>85-89</td>
        <td><select name="agg[]" id="14" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark14" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>90-94</td>
        <td><select name="agg[]" id="15" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark15" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
    </tr><tr>
        <td>95-100</td>
        <td><select name="agg[]" id="16" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="1">D1</option>
            <option value="2">D2</option>
            <option value="3">C3</option>
            <option value="4">C4</option>
            <option value="5">C5</option>
            <option value="6">C6</option>
            <option value="7">P7</option>
            <option value="8">P8</option>
            <option value="9">F9</option>
        </select></td>
        <td><input type="text" required name="remark[]" id="remark16" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>

    </tr>
</table>

        <div>
            <x-primary-button class="ml-4">
                {{ __('Set') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@endsection
