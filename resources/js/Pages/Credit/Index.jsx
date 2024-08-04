import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import PackagesPricingCards from '@/Components/PackagesPricingCards';

export default function Index({auth, success, error, packages, features})
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

                <div className='bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg relative mt-3 mb-3'>
                    <div className='flex flex-col gap-3 items-center p-4'>
                    {/* coing image */}
                        <img src='https://pngimg.com/uploads/coin/coin_PNG36871.png' className='w-[100px]' alt='coin image' />
                        <h3 className='text-amber-500'>You have {availableCredits} credits.</h3>
                    </div>
                </div>
                {/* Pricing card */}
                <PackagesPricingCards packages={packages.data} features={features.data}></PackagesPricingCards>
            </div>
        </div>
        </AuthenticatedLayout>
    );
}