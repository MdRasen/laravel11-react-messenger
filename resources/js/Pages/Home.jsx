import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import ChatLayout from "@/Layouts/ChatLayout";
import { Head } from "@inertiajs/react";

function Home() {
    return (
        <>
            <Head title="Dashboard" />
            Messages!
        </>
    );
}

Home.layout = (page) => {
    return (
        <AuthenticatedLayout user={page.props.auth.user}>
            <Head title="Dashboard" />
            <ChatLayout children={page} />
        </AuthenticatedLayout>
    );
};

export default Home;
