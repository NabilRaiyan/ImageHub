import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';


export default function Feature({ feature, answer, children }) {
    const { auth } = usePage().props;
    const availableCredits = auth.user.available_credits;

    console.log(feature);
    // Ensure feature is defined
    if (!feature) {
        return <div className='mt-8 text-center justify-center text-orange-400 text-xl'>Loading...</div>; // or any other fallback UI
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-orange-600 leading-tight">{feature.name}</h2>}
        >
            <Head title="Feature 1" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {answer !== null && (
                        <div className="text-white mb-3 py-3 rounded bg-emerald-600 text-xl">
                            Result of Calculation: {answer}
                        </div>
                    )}
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-800 relative">
                        {availableCredits !== null && feature.required_credits > availableCredits && (
                            <div className="absolute p-6 text-gray-900 left-0 top-0 right-0 bottom-0 flex flex-col z-20 items-center justify-center bg-white/70 gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="size-6">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                                <div>
                                    You don't have enough credits for this feature. Go {" "}
                                    <Link href='/' className='underline'>Buy more credits</Link>
                                </div>
                            </div>
                        )}

                        <div className='p-8 text-gray-400 border-b pb-4'>
                            <p className='text-orange-200'>{feature.description}</p>
                            <p className='text-sm italic text-right text-orange-300'>Requires {feature.required_credits} credits</p>
                        </div>
                        {children}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}


