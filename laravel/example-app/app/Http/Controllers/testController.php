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
    // Симулюємо створення нового повідомлення
    public function create()
    {
        // Симулюємо створення нового повідомлення
        $message = 'This is a new message';

        // Виводимо повідомлення
        return response()->json(['message' => 'Message created with text: ' . $message]);
    }

    // Симулюємо читання повідомлення за ID
    public function read($id)
    {
        // Симулюємо пошук повідомлення за ID
        $message = "Message with ID $id";

        return response()->json(['message' => $message]);
    }

    // Симулюємо оновлення повідомлення
    public function update($id)
    {
        // Симулюємо оновлення повідомлення
        $updatedMessage = "Updated message for ID $id";

        return response()->json(['message' => 'Message updated to: ' . $updatedMessage]);
    }

    // Симулюємо видалення повідомлення
    public function delete($id)
    {
        // Симулюємо видалення повідомлення
        return response()->json(['message' => 'Message with ID ' . $id . ' has been deleted!']);
    }
}
