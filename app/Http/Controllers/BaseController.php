<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    /**
     * Success response method.
     *
     * @param array $result
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    protected function sendResponse($result = [], $code = 200)
    {
        return response()->json($result, $code);
    }

    /**
     * Error response method.
     *
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    protected function sendErrorResponse($errorMessages = [], $code = 404)
    {
        return response()->json($errorMessages, $code);
    }

    /**
     * Prepare validated data with nullable fields.
     *
     * @param array $validated
     * @param array $nullableFields
     * @return array
     */
    protected function prepareUpdateValidated($validated, $nullableFields)
    {
        foreach ($nullableFields as $nullableField) {
            if (!isset($validated[$nullableField])) {
                $validated[$nullableField] = null;
            }
        }

        return $validated;
    }
}
