<table>

    <thead>

    <tr>

        <th>course id</th>

        <th>Course name</th>

        <th>Education id</th>


       

        

       

    </tr>

    </thead>

    <tbody>

    @foreach($course as $item)

   

    <?php $degreelevel = DB::table('degree_levels')->where('degree_level_id',$item->degree_level_id)->first(); ?>



        <tr>

            <td>{{ $item->id ?? '' }}</td>

            <td>{{ $item->course ?? '' }}</td>

           

            <td>{{ $item->education_id ?? '' }}</td>

           

          

           

        </tr>

      

    @endforeach

    </tbody>

</table>