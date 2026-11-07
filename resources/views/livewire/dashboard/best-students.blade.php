<x-card>

<h2 class="font-bold text-xl mb-4">

Top Students

</h2>

<table class="table-auto w-full">

<thead>

<tr>

<th>Name</th>

<th>Average</th>

</tr>

</thead>

<tbody>

@foreach($students as $student)

<tr>

<td>{{ $student->name }}</td>

<td>{{ number_format($student->average,1) }}%</td>

</tr>

@endforeach

</tbody>

</table>

</x-card>