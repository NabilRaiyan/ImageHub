import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';


export default function({auth, success, error, packages, features})
{
    const availableCredits = auth.user.available_credits;

    return(
        <AuthenticatedLayout user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Your Credits</h2>}
        >
        <Head title="Your Credits" />

        <div className='py-1'>
            <div className='max-w-7xl mx-auto sm:px-6 lg:px-8'>
                {/* show success and error message */}
                { 
                    success && 
                    <div className='rounded-lg bg-emerald-500 text-gray-100 p-3 mb-4'>
                        {success}
                    </div>
                }

                { 
                    error && 
                    <div className='rounded-lg bg-red-500 text-gray-100 p-3 mb-4'>
                        {error}
                    </div>
                }
            </div>

        </div>


        </AuthenticatedLayout>
    );
}