<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test method works!']);
    }
    public function create()
    {
        $message = 'This is a new message';

        return response()->json(['message' => 'Message created with text: ' . $message]);
    }

    public function read($id)
    {
        $message = "Message with ID $id";

        return response()->json(['message' => $message]);
    }

    public function update($id)
    {
        $updatedMessage = "Updated message for ID $id";

        return response()->json(['message' => 'Message updated to: ' . $updatedMessage]);
    }

    public function delete($id)
    {
        return response()->json(['message' => 'Message with ID ' . $id . ' has been deleted!']);
    }
}
