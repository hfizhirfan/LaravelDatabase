namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; // tambahkan baris ini

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', ['employees' => $employees]);
    }
}
