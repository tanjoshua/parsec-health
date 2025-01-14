<script lang="ts">
	import * as Tabs from "@/components/ui/tabs/index";
	import dayjs from "dayjs";
	import relativeTime from "dayjs/plugin/relativeTime";
	import type { Visit } from "@/types/visit";
	import { Button } from "../ui/button";
	import { page } from "@inertiajs/svelte";
	import type { Tenant } from "@/types/tenant";
	import { cn } from "@/utils";
	import ScrollArea from "../ui/scroll-area/scroll-area.svelte";

	dayjs.extend(relativeTime);

	let {
		selectedVisit = $bindable(),
		...props
	}: {
		selectedVisit: Visit | null;
		completedVisits: Visit[];
		activeVisits: Visit[];
		now: Date;
	} = $props();

	const pageProps = $page.props;
	const tenant = pageProps.tenant as Tenant;

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
	<Tabs.Root value="active">
		<div class="flex justify-between items-center">
			<h2 class="text-xl font-bold">Patient Visit Queue</h2>
			<div>
				<Tabs.List class="grid grid-cols-2">
					<Tabs.Trigger value="active">Active</Tabs.Trigger>
					<Tabs.Trigger value="completed">Completed</Tabs.Trigger>
				</Tabs.List>
			</div>
		</div>
		<Tabs.Content value="active">
			<ScrollArea class="h-[calc(100vh-9rem)]">
				<div class="mt-4 space-y-4">
					{#each props.activeVisits as visit}
						{@render visitCard(visit)}
					{/each}
				</div>
			</ScrollArea>
		</Tabs.Content>
		<Tabs.Content value="completed">
			<ScrollArea class="h-[calc(100vh-9rem)]">
				<div class="mt-4 space-y-4">
					{#each props.completedVisits.slice(0, 10) as completedVisit}
						{@render visitCard(completedVisit)}
					{/each}
					{#if props.completedVisits.length > 10}
						<div class="flex">
							<Button
								variant="outline"
								size="sm"
								class="w-full"
								href={`/tenants/${tenant.id}/visits`}
								>See all</Button
							>
						</div>
					{/if}
				</div>
			</ScrollArea>
		</Tabs.Content>
	</Tabs.Root>
</div>
