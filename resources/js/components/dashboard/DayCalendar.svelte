<script lang="ts">
    import dayjs from "dayjs";
    import { Clock } from "lucide-svelte";
    import { Button } from "../ui/button";
    import { onMount } from "svelte";
    import type { Appointment } from "@/types/appointment";
    import * as Card from "../ui/card";
    const props = $props<{
        now: Date;
        appointments: Appointment[];
    }>();

    const HOUR_BLOCK_HEIGHT_PX = 120;

    let scheduleContainer: HTMLDivElement;

    function indexToTime(index: number): string {
        if (index === 24) return "12 AM";
        const hour = index % 12 || 12;
        const period = index < 12 ? "AM" : "PM";
        return `${hour} ${period}`;
    }

    onMount(() => {
        scrollToCurrentTime();
    });

    function scrollToCurrentTime() {
        if (scheduleContainer) {
            const currentTimePosition =
                (dayjs(props.now).hour() + dayjs(props.now).minute() / 60) *
                HOUR_BLOCK_HEIGHT_PX;
            const containerHeight = scheduleContainer.clientHeight;
            const scrollPosition = currentTimePosition - containerHeight / 2;
            scheduleContainer.scrollTop = scrollPosition;
        }
    }

    function calculateTopPosition(startTime: Date): number {
        const startHour = dayjs(startTime).hour();
        const startMinute = dayjs(startTime).minute();
        return (startHour + startMinute / 60) * HOUR_BLOCK_HEIGHT_PX;
    }

    function calculateHeight(startTime: Date, endTime: Date): number {
        const start = dayjs(startTime);
        const end = dayjs(endTime);
        const durationInHours = end.diff(start, "minute") / 60;
        return durationInHours * HOUR_BLOCK_HEIGHT_PX;
    }
</script>

<div class="rounded-md border p-4 h-full">
    <div>
        <div class="text-2xl font-bold text-center" aria-live="polite">
            {dayjs(props.now).format("h:mm A")}
        </div>
        <div class="text-lg text-center text-muted-foreground">
            {dayjs(props.now).format("dddd, MMMM D, YYYY")}
        </div>
    </div>

    <div class="mt-4 flex justify-between items-center min-h-9">
        <div class="text-lg font-semibold">Today's Schedule</div>
        <Button onclick={scrollToCurrentTime} size="sm" variant="outline">
            <Clock />
            Now
        </Button>
    </div>

    <div
        class="mt-4 relative min-h-[480px] overflow-y-auto scroll-smooth"
        bind:this={scheduleContainer}
    >
        {#each Array.from({ length: 25 }, (_, i) => i) as hour}
            <div
                class="absolute w-full border-t text-xs text-muted-foreground"
                style:top="{hour * HOUR_BLOCK_HEIGHT_PX}px"
            >
                {indexToTime(hour)}
            </div>
        {/each}
        <div
            class="absolute w-full border-t-2 border-red-500 text-xs text-red-500 font-semibold text-end z-50"
            style:top="{(dayjs(props.now).hour() +
                dayjs(props.now).minute() / 60) *
                HOUR_BLOCK_HEIGHT_PX}px"
        >
            {dayjs(props.now).format("h:mm A")}
        </div>
        {#each props.appointments as appointment}
            <div
                class="absolute w-full pl-12"
                style:top="{calculateTopPosition(appointment.start_time)}px"
                style:height="{calculateHeight(
                    appointment.start_time,
                    appointment.end_time,
                )}px"
            >
                <Card.Root class="h-full">
                    <Card.Content>
                        <div class="font-semibold">
                            {appointment.patient_name}
                        </div>
                        <div class="text-sm text-foreground-muted">
                            {dayjs(appointment.start_time).format("h:mm A")} - {dayjs(
                                appointment.end_time,
                            ).format("h:mm A")}
                        </div>
                    </Card.Content>
                </Card.Root>
            </div>
        {/each}
    </div>
</div>
