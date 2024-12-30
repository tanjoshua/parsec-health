<script lang="ts">
    import { Card, CardContent } from "@/components/ui/card";
    import * as Tabs from "@/components/ui/tabs/index";
    import dayjs from "dayjs";
    import relativeTime from "dayjs/plugin/relativeTime";
    import type { Visit } from "@/types/visit";
    import * as Sheet from "../ui/sheet";

    dayjs.extend(relativeTime);

    const props = $props<{
        activeVisits: Visit[];
        now: Date;
    }>();

    let selectedVisit = $state<Visit | null>(null);

    function formatRegistrationDate(
        date: string | Date | undefined,
        now: Date,
    ) {
        if (!date) return "";
        const registrationDate = dayjs(date);
        return dayjs(now).isSame(registrationDate, "day")
            ? registrationDate.format("h:mm A")
            : registrationDate.format("DD/MM/YYYY h:mm A");
    }
</script>

{#snippet visitCard(visit: Visit)}
    <div>
        <Card
            class="cursor-pointer hover:shadow-md transition-shadow"
            onclick={() => (selectedVisit = visit)}
        >
            <CardContent>
                <div class="font-medium">
                    #{visit.patient.tenant_patient_number} - {visit.patient
                        .name}
                </div>
                <div class="text-sm font-light">
                    Registered: {formatRegistrationDate(
                        visit.registered_at,
                        props.now,
                    )}
                    ({dayjs(visit.registered_at).from(props.now)})
                </div>

                <div class="text-sm text-muted-foreground mt-2">
                    {visit.remarks}
                </div>
            </CardContent>
        </Card>
    </div>
{/snippet}

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

    <Sheet.Root
        open={!!selectedVisit}
        onOpenChange={(open) => {
            if (!open) {
                selectedVisit = null;
            }
        }}
    >
        <Sheet.Content>
            <Sheet.Header>
                <Sheet.Title>
                    #{selectedVisit?.patient.tenant_patient_number} -{" "}
                    {selectedVisit?.patient.name}
                </Sheet.Title>
            </Sheet.Header>
            <div class="py-4 grid gap-2">
                <div class="grid">
                    <div class="font-semibold">Registration</div>
                    <div>
                        {formatRegistrationDate(
                            selectedVisit?.registered_at,
                            props.now,
                        )}
                        ({dayjs(selectedVisit?.registered_at).from(props.now)})
                    </div>
                </div>
                <div class="grid">
                    <div class="font-semibold">Remarks</div>
                    <div>
                        {selectedVisit?.remarks}
                    </div>
                </div>
                <div class="grid">
                    <div class="font-semibold">Notes</div>
                    <div>
                        {selectedVisit?.notes}
                    </div>
                </div>
            </div>
        </Sheet.Content>
    </Sheet.Root>
</div>
