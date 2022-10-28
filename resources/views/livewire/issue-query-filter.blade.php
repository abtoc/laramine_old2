<div>
    <table class="table-sm table-borderless">
        <tbody>
            @foreach($filters as $filter)
                <tr>
                    <td class="text-start align-middle">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="check-filter-{{ $filter }}" name="f[]" value="{{ $filter }}" checked>
                            <label for="check-filter-{{ $filter }}" class="form-check-label">{{ __($filter) }}</label>
                        </div>
                    </td>
                    <td class="text-start align-middle">
                        <select name="op[{{ $filter }}]" id="check-op-{{ $filter }}" class="form-select form-select-sm" wire:model="operations.{{ $filter }}">
                            @foreach($conditions[$filter] as $op => $values)
                                <option value="{{ $op }}">{{ $operation_names[$op] }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="text-start align-middle">
                        {!! $items[$filter] !!}
                    </td>
                    <td class="text-end align-top">
                        @if($loop->first)
                            <div class="row">
                                <div class="col-auto">
                                    <label for="add-filter-select">{{ __('Add Filter') }}</label>
                                </div>
                                <div class="col-auto">
                                    <select id="add-filter-select" class="form-select form-select-sm" wire:model="addFilterSelect">
                                        @foreach($conditions as $key => $value)
                                            <option value="{{ $key }}" @disabled(in_array($key, $filters))>{{ __($key) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
