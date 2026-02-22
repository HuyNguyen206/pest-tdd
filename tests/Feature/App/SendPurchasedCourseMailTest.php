<?php


test('mail include course detail', function () {
    $course = \App\Models\Course::factory()->create();
   $mail = new \App\Mail\SendPurchasedCourseMail($course);

   $mail->assertSeeInText("Thanks for purchase course {$course->title}");
   $mail->assertSeeInText("Login");
   $mail->assertSeeInHtml(route('login'));
});
