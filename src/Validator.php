<?php


namespace Zqhong\FastdValidator;

use FastD\Http\Response;
use FastD\Http\ServerRequest;
use Illuminate\Support\Arr;
use Runner\Validator\Validator as RunnerValidator;

class Validator
{
    /**
     * @param ServerRequest $request
     * @param array $rules
     * @return RunnerValidator
     */
    public function validate(ServerRequest $request, array $rules)
    {
        $data = [];
        foreach ($rules as $field => $rule) {
            $field = explode('.', $field);
            $field = array_shift($field);
            if (array_key_exists($field, $data)) {
                continue;
            }
            if (isset($request->queryParams[$field])) {
                $data[$field] = $request->queryParams[$field];
            } elseif (isset($request->bodyParams[$field])) {
                $data[$field] = $request->bodyParams[$field];
            }
        }
        $validator = new RunnerValidator($data, $rules);
        if (!$validator->validate()) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, implode(',', Arr::flatten($validator->messages())));
        }
        return $validator;
    }
    public function validateRaw(array $validateData, array $rules)
    {
        $data = [];
        foreach ($rules as $field => $rule) {
            $field = explode('.', $field);
            $field = array_shift($field);
            if (array_key_exists($field, $data)) {
                continue;
            }
            if (isset($validateData[$field])) {
                $data[$field] = $validateData[$field];
            }
        }
        $validator = new RunnerValidator($data, $rules);
        if (!$validator->validate()) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, implode(',', Arr::flatten($validator->messages())));
        }
        return $validator;
    }
}