import { usePage } from "@inertiajs/react";

export default function CreditPricingCards({ packages, features}){
    const { csrf_token } = usePage().props;

    return(

        <section className="bg-gray-900">
            <div className="py-8 px-4">
                <div className="text-center mb-8">
                    <h2 className="mb-4 text-4xl font-extrabold text-white">
                        The more credits you choose the bigger savings you will make.
                    </h2>
                </div>
            </div>

        </section>
    );

}