import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, userPage } from '@inertiajs/react';


export default function FeatureComponent({feature, answer, children}){
    
    const { auth } = userPage().props;

    const availableCredits = auth.user.availableCredits;

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Feature 1</h2>}
        >
        <Head title="Feature 1" />

        <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {answer !== null && (
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-6 text-gray-900">Result of Calculation {answer}</div>
                    </div>
                )}
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-800 relative">
                    {availableCredits !== null && feature.required_credits > availableCredits && (
                        <div className="p-6 text-gray-900 absolute left-0 top-0 right-0 bottom-0 
                            flex flex-col items-center justify-center bg-white/70 gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                                <div>
                                    You don't have enough credits for this feature. Go {" "}
                                    <Link href='/' className='underline'>Buy more credits</Link>
                                </div>
                        </div>
                    )}

                    <div className='p-8 text-gray-400 border-b pb-4'>
                        <p>{feature.description}</p>
                        <p className='text-sm italic text-right'>Requires {feature.required_credits} credits</p>
                    </div>
                    {children}
                </div>
                    
                </div>
            </div>

            
        </AuthenticatedLayout>
    )
}