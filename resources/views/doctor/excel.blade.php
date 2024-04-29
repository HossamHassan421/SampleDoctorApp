<table>
    <thead>
    <tr role="row">
        <th>#</th>
        <th>{{trans('doctor.name')}}</th>
        <th>{{trans('doctor.mobile')}}</th>
        <th>{{trans('doctor.email')}}</th>
{{--        <th>{{trans('doctor.gender')}}</th>--}}
        <th>{{trans('doctor.is_active')}}</th>
        <th>{{trans('doctor.created_at')}}</th>

    </tr>
    </thead>
    <tbody>
    @if ($doctors->isNotEmpty())
        @foreach ($doctors as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->mobile }}</td>
                <td>{{ $row->email }}</td>
{{--                <td>--}}
{{--                    @if($row->gender == 1)--}}
{{--                        {{ trans('doctor.male') }}--}}
{{--                    @elseif($row->gender == 2)--}}
{{--                        {{ trans('doctor.female') }}--}}
{{--                    @endif--}}
{{--                </td>--}}
                <td>
                    @if($row->is_active == 1)
                        {{__('doctor.activate')}}
                    @else
                        {{__('doctor.deactivate')}}
                    @endif
                </td>
                <td class="nowrap">
                    {{  \Carbon\Carbon::parse($row->created_at)->locale(app()->getLocale())->isoFormat('YYYY-MM-DD hh:mmA') }}
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">
                {{ trans('doctor.no_data_available_in_table') }}
            </td>
        </tr>
    @endif
    </tbody>
</table>
