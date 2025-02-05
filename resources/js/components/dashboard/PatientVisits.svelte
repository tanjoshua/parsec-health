<script lang="ts">
	import * as Tabs from "@/components/ui/tabs/index";
	import dayjs from "dayjs";
	import relativeTime from "dayjs/plugin/relativeTime";
	import type { Visit } from "@/types/visit";
	import { Button } from "../ui/button";
	import { page } from "@inertiajs/svelte";
	import type { Tenant } from "@/types/tenant";
	import { cn, formatReadableDate } from "@/utils";
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
</script>

{#snippet visitCard(visit: Visit)}
	<div>
		<button
			class={cn(
				"hover:bg-accent flex flex-col gap-2 rounded-lg border p-3 text-left w-full",
				selectedVisit?.id === visit.id && "bg-muted",
			)}
			onclick={() => {
				if (selectedVisit?.id === visit.id) {
					selectedVisit = null;
				} else {
					selectedVisit = visit;
				}
			}}
		>
			<div class="flex w-full flex-col gap-1">
				<div class="flex items-start">
					<div class="">
						<div class="text-sm text-muted-foreground">
							#{visit.customer.tenant_customer_number}
						</div>
						<div class="font-semibold">
							{visit.customer.name}
						</div>
					</div>
					<div class={cn("ml-auto text-xs text-muted-foreground")}>
						{dayjs(visit.registered_at).from(props.now)}
					</div>
				</div>
				<div class="text-xs">
					Registered:
					<span class="font-semibold">
						{formatReadableDate(new Date(visit.registered_at))}
					</span>
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
