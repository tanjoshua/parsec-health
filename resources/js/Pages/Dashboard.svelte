<script lang="ts">
    import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.svelte";
    import CardHeader from "@/components/ui/card/card-header.svelte";
    import CardTitle from "@/components/ui/card/card-title.svelte";
    import Card from "@/components/ui/card/card.svelte";
    import * as Tabs from "@/components/ui/tabs/index";

    type Visit = {
        patient: {
            tenant_patient_number: number;
            name: string;
        };
    };

    let props: {
        activeVisits: Visit[];
    } = $props();
    console.log("Active Visits:", props.activeVisits);
</script>

<svelte:head>
    <title>Dashboard | Parsec Health</title>
</svelte:head>

{#snippet visitCard(visit: Visit)}
    <div>
        <Card class="cursor-pointer hover:shadow-md transition-shadow">
            <CardHeader>
                <CardTitle>
                    #{visit.patient.tenant_patient_number} - {visit.patient
                        .name}
                </CardTitle>
            </CardHeader>
        </Card>
    </div>
{/snippet}

<BreezeAuthenticatedLayout>
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold mb-4">Patient Visits</h2>
                </div>
                <Tabs.Root value="active">
                    <Tabs.List class="grid w-full grid-cols-2">
                        <Tabs.Trigger value="active">Active</Tabs.Trigger>
                        <Tabs.Trigger value="completed">Completed</Tabs.Trigger>
                    </Tabs.List>
                    <Tabs.Content value="active" class="mt-4 space-y-4">
                        {#each props.activeVisits as visit}
                            {@render visitCard(visit)}
                        {/each}
                    </Tabs.Content>
                    <Tabs.Content value="completed">
                        <div></div>
                    </Tabs.Content>
                </Tabs.Root>
            </div>
            <div></div>
        </div>
    </div>
</BreezeAuthenticatedLayout>
