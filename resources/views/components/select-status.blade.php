<select class="input w-full border border-gray-400" name="status" id="tabulator-html-filter-field">
    @if(request('status'))
    <option value="{{request('status')}}">{{request('status')}}</option>
    @endif
    <option value="">--- Status ---</option>
    <option value="New">New</option>
    <option value="Expired">Expired</option>
    <option value="Before Expired">Before Expired</option>
</select>