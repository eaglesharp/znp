<?php



namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\User;
use Mail;


class VerificationController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | Email Verification Controller

    |--------------------------------------------------------------------------

    |

    | This controller is responsible for handling email verification for any

    | user that recently registered with the application. Emails may also

    | be re-sent if the user didn't receive the original email message.

    |

    */



    use VerifiesEmails;



    /**

     * Where to redirect users after verification.

     *

     * @var string

     */

    protected $redirectTo = '/';



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        // $this->middleware('auth');

        $this->middleware('signed')->only('verify');

        $this->middleware('throttle:6,1')->only('verify', 'resend');

    }
    // protected function redirectTo() {
    //     return route('login');
    // }
    
    public function verify(Request $request)
    {
        $userId = $request->route('id'); // Get the user ID from the URL
        $user = User::findOrFail($userId);

        // Check if the verification link is valid
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return redirect('/')->withErrors(['message' => 'Invalid verification link.']);
        }

        // Check if the user's email is already verified
        if ($user->email_verified) {
            Mail::send('emails.frontuserregistered', $data, function($message) use ($data) {
    
                $message->to($data['title'])->from('info@zeronoticeperiod.com')
    
                ->subject($data['subject']);
    
              });
            return redirect('/')->with('msg', 'Your email is already verified.');
        }

        // Update email_verified column to 1 (true)
        $user->update(['email_verified' => 1,'email_verified_at' => date('Y-m-d H:i:s')]);

        // Trigger the Verified event
        event(new Verified($user));

        $data = [

            'title' =>   $user->email,

            'subject'  => 'Welcome to ZeroNoticePeriod | Jobseeker Account Verified',

            'content' =>  '',

            'name'     => $user->first_name,

            'link' => route('login'),

        ];
        Mail::send('emails.frontuserregistered', $data, function($message) use ($data) {

            $message->to($data['title'])->from('info@zeronoticeperiod.com')

            ->subject($data['subject']);

          });
        return redirect('/')->with('msg', 'Your email has been successfully verified.');
    }
    public function resend($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return redirect('login')->with('error_message', 'User not found.');
        }

        // Check if the user is already verified
        if ($user->email_verified) {
            return redirect('login')->with('error_message', 'Your email is already verified.');
        }

        event(new Registered($user));

        return redirect('login')->with('new_message', 'Verification email has been resent. Please check your inbox.');
    }

}

