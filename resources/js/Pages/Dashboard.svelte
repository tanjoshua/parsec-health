<script lang="ts">
    import PatientVisits from "@/components/dashboard/PatientVisits.svelte";
    import DayCalendar from "@/components/dashboard/DayCalendar.svelte";
    import type { Visit } from "@/types/visit";
    import type { Appointment } from "@/types/appointment";
    import type { Tenant } from "@/types/tenant";
    import TenantLayout from "@/Layouts/TenantLayout.svelte";

    const {
        activeVisits,
        appointments,
    }: {
        activeVisits: Visit[];
        appointments: Appointment[];
        tenant: Tenant;
    } = $props();

    // Add a reactive time value that updates every minute
    let now = $state(new Date());

    $effect(() => {
        const interval = setInterval(() => {
            now = new Date();
        }, 60000); // Update every minute

        return () => clearInterval(interval); // Cleanup on component destroy
    });
</script>

<svelte:head>
    <title>Dashboard | Parsec Health</title>
</svelte:head>

<TenantLayout>
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <PatientVisits {activeVisits} {now} />
            <DayCalendar {now} {appointments} />
        </div>
    </div>
</TenantLayout>
