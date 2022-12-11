<select class="input sm:w-32 xxl:w-full sm:w-auto text-sm border border-gray-400" name="status" id="tabulator-html-filter-field">
    @if(request('status'))
    <option value="{{request('status')}}">{{request('status')}}</option>
    @endif
    <option value="">--- Status ---</option>
    <option value="New">New</option>
    <option value="Oldest">Oldest</option>
    <option value="Expired">Expired</option>
    <option value="Before Expired">Before Expired</option>
</select>