<script lang="ts">
	import * as Tabs from "@/components/ui/tabs/index";
	import dayjs from "dayjs";
	import relativeTime from "dayjs/plugin/relativeTime";
	import type { Visit } from "@/types/visit";
	import * as Sheet from "../ui/sheet";
	import { Button } from "../ui/button";
	import { page } from "@inertiajs/svelte";
	import type { Tenant } from "@/types/tenant";
	import { cn } from "@/utils";

	dayjs.extend(relativeTime);

	const props: {
		completedVisits: Visit[];
		activeVisits: Visit[];
		now: Date;
	} = $props();

	const pageProps = $page.props;
	const tenant = pageProps.tenant as Tenant;

	let visitDrawerOpen = $state(false);
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
		<button
			class={cn(
				"hover:bg-accent flex flex-col gap-2 rounded-lg border p-3 text-left w-full",
				selectedVisit?.id === visit.id && "bg-muted",
			)}
			onclick={() => {
				selectedVisit = visit;
				visitDrawerOpen = true;
			}}
		>
			<div class="flex w-full flex-col gap-1">
				<div class="flex items-center">
					<div class="flex items-center gap-2">
						<div class="font-semibold">
							#{visit.patient.tenant_patient_number} - {visit
								.patient.name}
						</div>
						<!-- {#if true}
							<span
								class="flex h-2 w-2 rounded-full bg-blue-600"
							/>
						{/if} -->
					</div>
					<div
						class={cn(
							"ml-auto text-xs",
							selectedVisit?.id === visit.id
								? "text-foreground"
								: "text-muted-foreground",
						)}
					>
						{dayjs(visit.left_at).from(props.now)}
					</div>
				</div>
				<div class="text-xs font-medium">
					Registered: {formatRegistrationDate(
						visit.registered_at,
						props.now,
					)}
				</div>
			</div>
			<div class="text-muted-foreground line-clamp-2 text-xs">
				<!-- {item.text.substring(0, 300)} -->
				{visit.remarks}
			</div>
		</button>
	</div>
{/snippet}

<div>
	<div class="flex justify-between items-center">
		<h2 class="text-2xl font-bold mb-4">Patient Visit Queue</h2>
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
		<Tabs.Content value="completed" class="mt-4 space-y-4">
			{#each props.completedVisits.slice(0, 10) as completedVisit}
				{@render visitCard(completedVisit)}
			{/each}
			{#if props.completedVisits.length > 10}
				<div class="flex">
					<Button
						variant="outline"
						size="sm"
						class="w-full"
						href={`/tenants/${tenant.id}/visits`}>See all</Button
					>
				</div>
			{/if}
		</Tabs.Content>
	</Tabs.Root>

	<Sheet.Root
		open={visitDrawerOpen}
		onOpenChange={(open) => {
			if (!open) {
				visitDrawerOpen = false;
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
