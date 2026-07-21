<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Chapter;
use Illuminate\Database\Seeder;

class EnglishContentSeeder extends Seeder
{
    /**
     * Seed English translations for all Chapters and Modules.
     *
     * Strategy: Use Indonesian content as the initial English fallback,
     * so all modules display correctly in EN mode from day one.
     * Real English translations can be added to this seeder over time.
     *
     * To add a real translation:
     *   Find the module by its ID title (e.g., '1.1 Rotunda'),
     *   and replace the content below with actual English text.
     *
     * @return void
     */
    public function run()
    {
        // Map of module title (ID) => English content override
        // Add real English translations here as they become available
        $englishContent = [
            '1.1 Rotunda' => '<p><strong>The main components of Garbarata consist of:</strong></p>

        <p>
            The <strong>Rotunda</strong> is designed as the central axis for the vertical and horizontal movement of the Garbarata.
            During operation, rotunda columns, floors, ceilings and corridor wall panels are abutted
            with the terminal not moving (static), while the rotunda rigid frame and roof will rotate
            adjust column movement. The rotunda consists of:
        </p>

        <ul class="space-y-4">
            <li>
                <strong>a) Rotunda Corridor</strong><br>

                The Rotunda Corridor is the link between the rotunda and the terminal building.
                The Rotunda Corridor is designed using flexible weather seals and floor steps
                with a hinge connection from the rotunda to the terminal building so that there is no load
                as well as vibrations from the Garbarata which are channeled to the fixed link.
            </li>

            <li>
                <strong>b) Rotunda Support Column</strong><br>

                The Rotunda Support Column is a static support for the Garbarata.
                Rotunda Support column rests on the foundation with eight anchor bolts
                each of which is equipped with 3 nuts.
            </li>

            <li>
                <strong>c) Main Distribution Panel</strong><br>

                The electrical panel is installed on the equipped rotunda support column
                with circuit breakers and transformers needed to change
                and adjust the need for electric current supplied from the tenninal building
                for electricity needs at Garbarata.
            </li>

            <li>
                <strong>d) Aluminum Side Curtains</strong><br>

                Aluminum side curtains are installed on both sides of the rolling Rotunda
                on a coil on each side and can follow the rotational movement of the rotunda.
                Both coils have springs attached along the axis to provide
                tension on the curtain and keep it tight and tight.
            </li>

            <li>
                <strong>e) Rotunda Swing Limit Switches</strong><br>

                The limit switch is mounted on a rotating rigid frame at the bottom of the rotunda,
                and the cam is installed on the static/non-rotating rotunda flange.
            </li>
        </ul>',
            '1.2 Telescopic Tunnel' => '<p>
            Starting from the rotunda, the tunnels are called tunnels A, B and C
            for 3 tunnel Garbarata (A and B for 2 tunnel Garbarata). Telescoping tunnel
            rectangular in shape, with the largest tunnel size being close to the plane.
        </p>

        <p>
            All tunnels are made of corrugated plate with supporting flanges. Holes
            Drilled into the roof flange so water can flow down. Water channels are made
            on each side of the Garbarata floor, inside Tunnels B and C.
        </p>

        <ul class="space-y-4">
            <li>
                <strong>a) Rails and Roller Bearings</strong><br>

                Rails for the roller track are made on each side so that the Garbarata can move
                forward and backward smoothly. All tunnels have roller tracks at the top
                and bottom. A stopper is welded to the lower roller track of tunnel B
                to prevent the roller from coming out of the end of the track.
            </li>

            <li>
                <strong>b) Rotunda Guide Rollers</strong><br>

                Tunnel guide rollers are installed on the left and right sides of the rotunda, the main function
                The purpose of this guide roller is to maintain the distance and position between
                tunnel with a rigid frame when the Garbarata moves up, down and
                rotating (left and right).
            </li>

            <li>
                <strong>c) Cable Scissors</strong><br>

                Cable scissors are installed under the tunnel, holding and carrying the power cable
                and control cables to remain connected while the Garbarata extends and
                shortened. The scissor cable is connected between the back of tunnel A to
                rear of tunnel B.
            </li>

            <li>
                <strong>d) Ramps</strong><br>

                In the telescoping tunnel section that intersects tunnel A
                and B, there is a transition bridge (ramp) and also between tunnel B
                and C which is used to overcome height differences on the floor
                tunnels. This ramp is attached to the tunnel using hinges. Handrails
                installed on the right and left.
            </li>

            <li>
                <strong>e) Glass Wall Panels</strong><br>

                Colored glass is installed along the tunnel walls. Glass walls installed
                with a floating system so there is no pressure or load
                weighing down the glass walls.
            </li>

            <li>
                <strong>f) Roof Safety Hand Rail</strong><br>

                Roof safety hand rail is installed on the roof which functions as
                safety for airport crew who are working on the Garbarata roof.
            </li>
        </ul>',
            '1.3 Vertical Lift Column' => '<p>
            The vertical lift column consists of a ball screw and nut installed in a square steel tube.
            Column lift components also include a vertical drive motor, brake system,
            cable tray, and limit switch.
        </p>

        <ul class="space-y-4">
            <li>
                <strong>a) Ball screws and nut assembly</strong><br>

                The ball screw and nut consist of a chain coupler, thrust bearing, top plate,
                oil cup, wiper and safety device. Ball screws and nuts have concave
                helical ball race, forms a closed groove where the bearing balls
                rotates uniformly with the rotation of the screw. If the motor is running, the ball nut
                will move along the axis of the screw, changing the rotational motion of the screw
                be a straight linear movement of the nut.
            </li>

            <li>
                <strong>b) Grease Nipple</strong><br>

                Lubrication of the ball screw and nut can be done via the grease nipple
                is on the outside of the bottom column. Raise the lift column to the highest position
                high, then attach the grease gun to the grease nipple. Start adding grease
                while lowering the lift column to the lowest position. Repeat process
                applying grease if necessary.
            </li>

            <li>
                <strong>c) Vertical Drive Motors and Brakes</strong><br>

                This vertical drive motor uses an electro-magnetic system and brakes
                spring-setting, which is designed to stop and hold a load with
                right. The brake system is connected directly to the motor terminals so that
                will automatically release the brake when the motor is activated.
            </li>

            <li>
                <strong>d) Cable tray assembly</strong><br>

                The cable tray on the drive column contains the cables from the wheel bogie.
                The cable is routed from the J-box under tunnel C, through the cable tray and
                ends in a horizontal motor.
            </li>

            <li>
                <strong>e) Height Indicator</strong><br>

                The bridge has a proximity switch located on the motor flange on the side
                on the drive column to detect the number of rotations of the ball screw. This signal
                sends data digitally to the control console which is then processed
                to show how far the Garbarata has moved up or down.
            </li>
        </ul>',
            '1.4 Wheel Boogie' => '<p>
            <strong>Wheel Boogie</strong> consists of frame, tires, drive chain,
            electric motor, limit switch box, landing gear (optional) and
            electrical cables.
        </p>

        <ul class="space-y-4">
            <li>
                <strong>a) Wheels</strong><br>

                Two solid tires are installed on the frame. Trunions help distribute
                The load held on each wheel is balanced.
            </li>

            <li>
                <strong>b) Chains Drives</strong><br>

                The right and left wheels have two chains with duplex sprockets
                on the motor shaft and wheels. Chain guard protects workers on the apron.
            </li>

            <li>
                <strong>c) Limit Switch</strong><br>

                The steering limit switch is installed on the cross beam below the bogie.
                If the bogie turns left or right, the cam limit switch will
                Touch the limit switch at the end of the steering limit and activate it
                warning buzzer on the control console to indicate oversteering.
            </li>

            <li>
                <strong>d) Motors and Brakes</strong><br>

                Each drive chain is connected to a motor gear. 3 phase motor
                It uses electro-magnetic brakes, which release braking power
                at the same time as the motor is activated. Those brakes too
                can be released manually, this is required in the circumstances
                emergency, if the Garbarata needs to be towed/moved when it is not
                there is electric power.
            </li>

            <li>
                <strong>e) Safety Hoop</strong><br>

                A safety hoop is a functional safety device
                to anticipate the presence of objects or personal beings that are close by
                with wheel boogie. Safety hoop made of RHS with sides
                1 inch cross section.
            </li>
        </ul>',
            '1.5 Service Access' => '<p>
            Service doors, platforms and stairs are located on the right and left sides
            at the front of the tunnel. This service access provides a path from the apron to
            Garbarata or vice versa for ground crew.
        </p>

        <ul class="space-y-4">
            <li>
                <strong>a) Service Door</strong><br>

                Service door is a steel door that is equipped with
                glass window, opening towards the outside of the platform.
            </li>

            <li>
                <strong>b) Platforms</strong><br>

                The height of the platform is made the same as the cabin floor.
                The platform floor is made of checkered patterned aluminum
                mounted on a galvanized steel frame and surrounded by
                galvanized steel handrail. A light is installed above the service
                door to illuminate the platform.
            </li>

            <li>
                <strong>c) Service Stairs</strong><br>

                This ladder is a self-adjusting ladder mounted on a frame
                galvanized steel and handrails are installed on both sides of the stairs.
                Self-adjusting means the ladder can adjust its height
                according to the position of the Garbarata up and down. Castor wheel supports
                service stair and allows the stairs to follow the Garbarata
                operates around the apron.
            </li>

            <li>
                <strong>d) Roof Access Ladder</strong><br>

                A galvanized ladder is attached to the leading platform
                tunnel roof as access for maintenance crews.
            </li>
        </ul>',
            '1.6 Cabin' => '<p>
            <strong>Cabin</strong> is made of steel, the exterior is coated
            with epoxy base paint and interior parts with floor covering,
            ceiling and lighting. The electric motor is installed in the section
            The bottom of the cabin functions to rotate the cabin. There is also a cabin in the cabin
            side curtain, double swing door, and control console.
        </p>

        <ul class="space-y-4">
            <li>
                <strong>a) Double Swing Door</strong><br>

                A double swing door is attached to the cabin, when closed
                The double swing door can protect the interior and operator
                from the conditions outside and around it when the Garbarata is in operation
                not used.
            </li>

            <li>
                <strong>b) Closure</strong><br>

                When Garbarata docks with a plane, closure
                cover the gaps between the cabin and the plane. Closure
                shaped in folds and made of weather-resistant material.
                Pressure-sensitive limit switches on both sides prevent
                closure suppresses excessive fuselage.
            </li>

            <li>
                <strong>c) Side Curtains</strong><br>

                Curtain is made of aluminum and like the rotunda,
                The curtain has a right and left side, which can roll up
                on a coil following the cabin during rotation. Second
                The coil has a spring attached along the axis
                to provide tension on the curtain, keeping it steady
                tense and tight.
            </li>

            <li>
                <strong>d) Control Console</strong><br>

                In the Control panel there are all the necessary controls
                to operate the Garbarata. These controls will
                explained in another chapter that discusses operational controls.
            </li>

            <li>
                <strong>e) Safety Door Shoe</strong><br>

                Safety Door Shoe is a back up sensor for the bridge when
                autolevel cannot detect changes in altitude.
                Safety door shoes must be positioned under the aircraft door
                during the docking process.
            </li>
        </ul>',
            '2.1 Main-Distribution Panel' => '<figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
            <img src="/images/modules/main_distribution_panel.png"
                class="mx-auto max-h-96 w-full object-contain rounded-lg"
                alt="Main Distribution Panel">
        </figure>
        <p class="text-center text-sm text-gray-600 mb-6">
            Main-Distribution Panel
        </p>
        <p>
            The Main-Distribution Panel is positioned on the Rotunda Column of the Garbarata.
            Its main function is to transfer and share electrical power
            from the airport building to the Garbarata safely.
        </p>
        <br>
        <p><strong>The internal components of the Main Power Panel are as follows:</strong></p>
        <br>
        <p><strong>(a) Circuit Breaker (MCCB/ MCB/ ELCB)</strong></p>
        <p>
            Circuit Breaker functions to protect energy from airport buildings
            towards Garbarata. Circuit Breakers used such as MCCB,
            MCB and ELCB to control power
        </p>

        <ul class="list-disc ml-6 mt-2">
            <li>Main Power Breaker for Main Distribution Panel</li>
            <li>Main Power Breaker for Drive Power</li>
            <li>Main Power Breaker for Lighting and Control System</li>
            <li>Main Power Breaker for Air Conditioner System</li>
            <li>Main Power Breaker for Rotunda Air Conditioner</li>
            <li>etc (as needed)</li>
        </ul>

        <br>

        <p><strong>(b) Contactor (C)</strong></p>

        <p>
            Contactors connect electrical power to several components.
            When a failure occurs, the Contactor will open and disconnect
            all electrical power to the component.
        </p>

        <br>

        <p><strong>(c) Terminal Block (TB) and Terminal Strip (TS)</strong></p>

        <p>
            TB and TS are used as cable terminals.
        </p>

        <br>

        <p><strong>(d) Relay (RL)</strong></p>

        <p>
            Relays are used to control circuits using signals
            low powered or where multiple circuits are required
            controlled with a single signal.
        </p>

        <br>

        <p><strong>(e) Pilot Lamp (PL)</strong></p>

        <p>
            Three indicator lights as indicators of electric power flow
            Garbarata.
        </p>',
            '2.2 Distribution Power Panel' => '<p>
            The Distribution Power Panel consists of transistors, inverters,
            magnetic contactor and circuit breaker. All positions and types
            The components in the Distribution Power Panel differ depending
            consumer needs. Specific detailed data is shown in the figure
            As-Built.
        </p>

        <br>

        <p><strong>(a) Circuit Breaker (MCB/ MCCB/ ELCB)</strong></p>

        <p>
            Circuit Breaker functions to protect energy from airport buildings
            towards Garbarata. The Circuit Breaker used is like an MCCB.
            MCB and ELCB to control power
        </p>

        <ol class="list-decimal ml-6 mt-2 space-y-1">
            <li>Lighting Power Breaker</li>
            <li>Control Power Breaker</li>
            <li>Receptacle Power breaker</li>
            <li>Horizontal Motor Breaker</li>
            <li>Vertical Motor breaker</li>
            <li>Cabin Motor breaker</li>
            <li>Air Conditional Breaker</li>
        </ol>

        <br>

        <p><strong>(b) Contactor</strong></p>

        <ol class="list-decimal ml-6 mt-2 space-y-4">
            <li>
                <strong>Tunnel lights and rotunda main contactor</strong>

                <p class="mt-2">
                    Magnetic contactors are used to connect power
                    from the Lighting Power Breaker to the tunnel lights and
                    rotunda. The operating system is on the console desk
                    in the Cabin.
                </p>
            </li>

            <li>
                <strong>Magnetic Contactor</strong>

                <p class="mt-2">
                    Magnetic contactor reverses CW/CCW motor rotation
                    according to PLC commands
                </p>
            </li>
        </ol>

        <br>

        <p><strong>(c) Variable Speed Drive</strong></p>

        <p>
            Garbarata uses several Variable Speed transistor units
            Drive, the inverter uses power through Main
            Contactor.
        </p>

        <br>

        <p><strong>(d) Thermal Overloads</strong></p>

        <p>
            Thermal Overload is on the Power Panel Box and will trip
            and stops the motor when the component is overloaded.
            The circuit will remain open until the thermal overload is reset
            back. And this will also reset the contactor.
        </p>',
            '2.3 Console Desk' => '<p>
            The bridge is managed and controlled via the Console Desk.
            On the Console Desk there is a Control Interface (Buttons and Touchscreen)
            and Control Panel (Relay, Fuse, and PLC)
        </p>
        <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
            <img src="/images/modules/console_desk.png"
                class="mx-auto max-h-96 w-full object-contain rounded-lg"
                alt="Console Desk">
        </figure>
        <p class="text-center text-sm text-gray-600 mb-6">
            Console Desk
        </p>

        <br>
        <h4><strong>(a) Control Interface</strong></h4>
        <p>
            The control interface is positioned above the Console Desk.
            The touchscreen displays the condition of the Garbarata via several indicators.
            Operation details are explained in Chapter three.
        </p>

        <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
            <img src="/images/modules/control_interface.png"
                class="mx-auto max-h-96 w-full object-contain rounded-lg"
                alt="Control Interface">
        </figure>
        <p class="text-center text-sm text-gray-600 mb-6">
            Control Interface
        </p>
        <br>

        <h4><strong>(b) Control Panel</strong></h4>
        <p>
            All operating systems are in the Control Panel and positioned
            under Control Interface. Garbarata control center is located at
            that part.
        </p>',
            '2.4 Pencahayaan' => '<p><strong>a. Interior Lighting</strong></p>
        <div class="overflow-x-auto my-6">
            <table class="w-full border border-black border-collapse text-sm">
                <tbody>
                    <tr>
                        <td class="border border-black px-4 py-2">
                            Tunnel Lights
                        </td>
                    </tr>

                    <tr>
                        <td class="border border-black px-4 py-2">
                            Rotunda Lights
                        </td>
                    </tr>

                    <tr>
                        <td class="border border-black px-4 py-2">
                            Cabin Lights
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p><strong>b. Exterior Lighting</strong></p>
        <div class="overflow-x-auto my-6">
            <table class="w-full border border-black border-collapse text-sm">
                <tbody>
                    <tr>
                        <td class="border border-black px-4 py-2">
                            Landing Stair Lights
                        </td>
                    </tr>

                    <tr>
                        <td class="border border-black px-4 py-2">
                            Obstruction Lights
                        </td>
                    </tr>

                    <tr>
                        <td class="border border-black px-4 py-2">
                            Rotary Lamp
                        </td>
                    </tr>

                    <tr>
                        <td class="border border-black px-4 py-2">
                            Flood light Tunnel Light
                        </td>
                    </tr>

                    <tr>
                        <td class="border border-black px-4 py-2">
                            Cabin LED Light
                        </td>
                    </tr>

                    <tr>
                        <td class="border border-black px-4 py-2">
                            Control Panel Lights
                        </td>
                    </tr>

                    <tr>
                        <td class="border border-black px-4 py-2">
                            Flood light cabin LED Light
                        </td>
                    </tr>

                    <tr>
                        <td class="border border-black px-4 py-2">
                            Emergency LED Light
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <p>
            The exterior and interior lighting control center is located at
            <strong>Console Desk</strong>.
        </p>',
            '2.5 Safety Device / Sensor / Actuator' => '<p>
            Garbarata uses an electric motor and mechanical system
            equipped with various <strong>Safety Devices</strong>,
            <strong>Sensors</strong>, and <strong>Actuators</strong> for
            guarantee operational safety. Following are the components
            which are found in every part of the Garbarata.
        </p>

<p><strong>a. Rotunda</strong></p>

<div class="overflow-x-auto my-6">
            <table class="w-full border border-gray-500 border-collapse text-sm">
                <tbody>

<tr>
                        <td class="border border-gray-500 px-4 py-2 w-1/2">
                            Initial Rotunda Left / Right limit switches
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            To limit horizontal rotation of the Rotunda
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Ultimate Rotunda Left / Right limit switches
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Proximity Slope Up/Down
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit changes in the height of the Garbarata
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Encoder Rotunda Rotation sensor
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Determine the angular position of the Rotunda
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Potentiometer Rotunda Rotation Sensor
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Determine the angular position of the rotunda
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            CCTV Cameras / Closed Circuit Television
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Check the apron situation
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Camera Box and Wiper
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Protects the Camera from external interference
                        </td>
                    </tr>

</tbody>
            </table>
        </div>

<p><strong>b. Tunnel (A/B/C)</strong></p>

<div class="overflow-x-auto my-6">
            <table class="w-full border border-gray-500 border-collapse text-sm">
                <tbody>

<tr>
                        <td class="border border-gray-500 px-4 py-2 w-1/2">
                            Limit switches Initial Full Retract & Full Extend
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Limiting changes to the length of the Garbarata
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Ultimate Full Retract & Full Extend limit switches
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit switch Slow down Tunnel Travel
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Slows down the Garbarata speed when approaching the fuselage
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Proximity Travel Tunnel Sensor
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Detect changes in the length of the Garbarata
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Proximity Reset Travel Tunnel Sensor
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            As a sensor calibrator
                        </td>
                    </tr>

</tbody>
            </table>
        </div>

<p><strong>c. Cabin</strong></p>

<div class="overflow-x-auto my-6">
            <table class="w-full border border-gray-500 border-collapse text-sm">
                <tbody>

<tr>
                        <td class="border border-gray-500 px-4 py-2 w-1/2">
                            Bumper Limit switch
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            To detect the fuselage
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Horn/Bell
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            As a signal that Garbarata is operating
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Safety Door Shoes
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Backup if autolevel doesn\'t work
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Photo Electric Switch
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            To detect the position of the aircraft and slow down the Garbarata speed
                        </td>
                    </tr>

</tbody>
            </table>
        </div>

<br>
        <p><strong>Canopy</strong></p>
        <div class="overflow-x-auto my-6">
            <table class="w-full border border-gray-500 border-collapse text-sm">
                <tbody>

<tr>
                        <td class="border border-gray-500 px-4 py-2 w-1/2">
                            Limit switch Left Canopy Retract
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Limits canopy movement when retracting
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit switch Right Canopy Retract
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit switch Left Canopy Stop/Extend & over Pressure
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Limits canopy movement if there is excess pressure
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit switch Right Canopy Stop/Extend & over Pressure
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            R/L Canopy Motor Actuator
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            To move the canopy
                        </td>
                    </tr>

</tbody>
            </table>
        </div>
        <p><strong>Cabin Rotation</strong></p>

<div class="overflow-x-auto my-6">
            <table class="w-full border border-gray-500 border-collapse text-sm">
                <tbody>
                    <tr>
                        <td class="border border-gray-500 px-4 py-2 w-1/2">
                            Limit switch Initial Cabin Rotation Left & Ultimate Cabin Rotation Left
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Limits the rotational movement of the cabin to the left
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit switch Initial Cabin Rotation Right & Ultimate Cabin Rotation Right
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Limits rotational movement of the cabin to the right
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Proximity Cabin Rotation Sensor
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Detecting the angular position of the cabin
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Proximity Reset cabin rotation sensor
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            As a sensor calibrator
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Cabin Rotation Motor Actuator
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            To move the cabin
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Proximity Cabin Floor Up / Down
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Detect changes in cabin floor height
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Cabin Floor Motor Actuator
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Move the cabin floor
                        </td>
                    </tr>

</tbody>
            </table>
        </div>
        <p><strong>Autolevel</strong></p>

<div class="overflow-x-auto my-6">
            <table class="w-full border border-gray-500 border-collapse text-sm">
                <tbody>
                    <tr>
                        <td class="border border-gray-500 px-4 py-2 w-1/2">
                            Proximity Ultimate Auto level Wheel Up/Down
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            To detect changes in aircraft altitude
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Proximity Auto level Not Out
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Detects if autolevel does not exit
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Proximity Auto level Not Contact
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Detects if the autolevel is not in contact with the fuselage
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit Switch Auto level Wheel Up/Down
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Detect autolevel wheel rotation
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit Switch Actuator Motor Auto level Stop
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Detects autolevel if it has been in contact with the aircraft
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Actuator Motor Auto level
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            To move the autolevel
                        </td>
                    </tr>

</tbody>
            </table>
        </div>

<p><strong>d. Column Elevator</strong></p>
        <div class="overflow-x-auto my-6">
            <table class="w-full border border-gray-500 border-collapse text-sm">
                <tbody>
                    <tr>
                        <td class="border border-gray-500 px-4 py-2 w-1/2">
                            Vertical Column L/R Motor Actuator
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Moving the lift column
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Proximity Counter Column Right
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Detecting the height of the Garbarata
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Proximity Reset Counter Column Right
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            As a sensor calibrator
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit Switch Column Fault Left
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Detect if the lift column is unbalanced
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit Switch Column Fault Right
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit Switch Initial Vertical Up/Down Left
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            As an initial sensor
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit Switch Initial Vertical Up/Down Right
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit Switch Ultimate Vertical Up/Down Left
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            As the ultimate sensor
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit Switch Ultimate Vertical Up/Down Right
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

<p><strong>e. Wheel Boogie</strong></p>
        <div class="overflow-x-auto my-6">
            <table class="w-full border border-gray-500 border-collapse text-sm">
                <tbody>
                    <tr>
                        <td class="border border-gray-500 px-4 py-2 w-1/2">
                            Limit switch Initial Steer Left
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            As a wheel boogie initial sensor
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Limit switch Initial Steer Right
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Ultimate Steer Right limit switch
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            As the ultimate wheel boogie sensor
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Ultimate Steer Left limit switch
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Encoder Wheel Boogie Rotation Sensor
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            Detecting wheel boogie rotation
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Safety Hoop limit switch
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            As a protector and detector for the boogie wheel from foreign objects
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Horizontal Drive L/R Motor Actuator
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            To move the boogie wheel
                        </td>
                    </tr>

<tr>
                        <td class="border border-gray-500 px-4 py-2">
                            Inverter Variable speed drive Horizontal motor Left/right
                        </td>
                        <td class="border border-gray-500 px-4 py-2">
                            To speed up or slow down the boogie wheel
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

',
            '1.1 Model' => '<p>
        Models and types of Garbarata vary depending on consumer demand. For naming types
        Garbarata is determined based on the length of the Garbarata from the center of the Rotunda to the end
        cabin bumper at short and maximum length. International Airport Garbarata
        Sultan Hasanuddin, Makassar has types B3 - 22/39 and B2 - 21/28 which are
        Three tunnel or two tunnel garbarata with minimum length of garbarata when shortened
        according to the specified type. For example, B3 - 22/39 has meaning
        22 meters when the Garbarata is maximally shortened and 39 meters when maximally extended.
        Likewise, it has the same meaning as type B2 - 21/28.
    </p>

    <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/garbarata_2Tunnel.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Garbarata">
    </figure>

    <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/garbarata_3Tunnel.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Garbarata 3 tunnel">
    </figure>

    <div class="overflow-x-auto my-6">
        <table class="w-full border-collapse text-sm">
            <head>
        <tr>
            <th colspan="5" class="border-b-2 border-gray-700 py-2 text-center text-lg font-bold">
                General Specifications
            </th>
        </tr>
            </thead>s
            <tbody>
        <tr class="border-b border-gray-400">
            <td class="py-2 font-medium w-1/3">Type Number</td>
            <td class="py-2 w-4">:</td>
            <td class="py-2 font-semibold">B2 - 21/28 SWRGG</td>
            <td class="py-2 font-semibold">B3 - 22/39 SWLGG</td>
        </tr>
        <tr class="border-b border-gray-400">
            <td class="py-2 font-medium">Number of PBB</td>
            <td>:</td>
            <td>3 units</td>
            <td>3 units</td>
        </tr>
        <tr class="border-b border-gray-400">
            <td class="py-2 font-medium">Number of Tunnels</td>
            <td>:</td>
            <td>2 Tunnels</td>
            <td>3 Tunnels</td>
        </tr>
        <tr class="border-b border-gray-400">
            <td class="py-2 font-medium">Service Door Position</td>
            <td>:</td>
            <td>Right</td>
            <td>Left</td>
        </tr>
        <tr class="border-b border-gray-400">
            <td class="py-2 font-medium">Tunnel Side Wall</td>
            <td>:</td>
            <td>Glass Wall</td>
            <td>Glass Wall</td>
        </tr>
            </tbody>
        </table>
    </div>',
            '1.2 Batasan Rancangan' => '<div class="overflow-x-auto my-6">
        <table class="w-full border-collapse text-sm">
            <tbody>
        <tr class="border-b border-gray-500">
            <td class="py-2 px-3 font-medium">Maximum floor load</td>
            <td class="py-2 px-3 text-right">200 kg/m<sup>2</sup></td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="py-2 px-3 font-medium">Maximum roof load</td>
            <td class="py-2 px-3 text-right">122 kg/m<sup>2</sup></td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="py-2 px-3 font-medium">Maximum wind speed in operation</td>
            <td class="py-2 px-3 text-right">27 m/s</td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="py-2 px-3 font-medium">Maximum wind speed not in operation</td>
            <td class="py-2 px-3 text-right">40 m/s</td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="py-2 px-3 font-medium">Ambient temperature</td>
            <td class="py-2 px-3 text-right">35°C</td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="py-2 px-3 font-medium">Maximum humidity</td>
            <td class="py-2 px-3 text-right">80%</td>
        </tr>
            </tbody>
        </table>
    </div>',
            '1.3 Dimensi' => '<p><strong>1.3.1 Internal Dimensions</strong></p>
    <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/dimensi_internal.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Internal dimensions">
    </figure>

    <div class="overflow-x-auto my-6">
        <table class="w-full border-collapse text-sm">
            <head>
        <tr>
            <th colspan="2" class="py-2 text-center text-lg font-bold">B2 - 23/32 SWRGG</th>
        </tr>
            </head>
            <tbody>
        <tr class="border-b border-gray-500">
            <td class="py-2 px-3 font-medium">Minimum Clear Internal Width (A)</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">1.49 m</td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="py-2 px-3 font-medium">Minimum Clear Internal Height (B)</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">2.15 m</td>
        </tr>
            </tbody>
        </table>
    </div>

    <p><strong>1.3.2 Maximum and Minimum Length</strong></p>
    <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/max_min_length.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Maximum and minimum length">
    </figure>

    <div class="overflow-x-auto my-6">
        <table class="w-full border-collapse text-sm">
            <head>
        <tr>
            <th colspan="2" class="py-2 text-center text-lg font-bold">B2 - 23/32 SWRGG</th>
        </tr>
            </head>
            <tbody>
        <tr class="border-b border-gray-500">
            <td class="py-2 px-3 font-medium">Retracted operation limit (A)</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">23 m</td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="py-2 px-3 font-medium">Extended operation limit (B)</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">32 m</td>
        </tr>
            </tbody>
        </table>
    </div>',
            '1.4 Performa' => '<p><strong>1.4.1 Garbarata Movement</strong></p>

<p><strong>a. Vertical Movement</strong></p>
    <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/gerakan_vertikal.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Vertical movement">
    </figure>
    <p class="text-center font-bold my-2"><strong>B2 - 23/32 SWRGG</strong></p>
    <div class="overflow-x-auto my-4">
        <table class="w-full border border-gray-500 border-collapse text-sm">
            <tbody>
        <tr class="border-b border-gray-500">
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Lowest level (A)</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">2.0 m</td>
        </tr>
        <tr>
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Highest level (B)</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">5.4 m</td>
        </tr>
            </tbody>
        </table>
    </div>

<p><strong>b. Rotunda Horizontal Turning Angle</strong></p>
    <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/sudut_putar_horizontal_rotunda.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Rotunda horizontal rotation angle">
    </figure>
    <p class="text-center font-bold my-2"><strong>B2 - 23/32 SWRGG</strong></p>
    <div class="overflow-x-auto my-4">
        <table class="w-full border border-gray-500 border-collapse text-sm">
            <tbody>
        <tr class="border-b border-gray-500">
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Maximum left swing (A)</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">87.5°</td>
        </tr>
        <tr>
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Maximum right swing (B)</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">87.5°</td>
        </tr>
            </tbody>
        </table>
    </div>

<p><strong>c. Cabin Rotation Turning Angle</strong></p>
    <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/sudut_putar_rotasi_cabin.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Cabin rotation angle">
    </figure>
    <p class="text-center font-bold my-2"><strong>B2 - 23/32 SWRGG</strong></p>
    <div class="overflow-x-auto my-4">
        <table class="w-full border border-gray-500 border-collapse text-sm">
            <tbody>
        <tr class="border-b border-gray-500">
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Maximum left rotation (A)</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">75°</td>
        </tr>
        <tr>
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Maximum right rotation (B)</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">75°</td>
        </tr>
            </tbody>
        </table>
    </div>

<p><strong>d. Wheel Boogie Rotation Angle</strong></p>
    <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/sudut_putar_rotasi_wheel_boogie.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Boogie wheel rotation angle">
    </figure>
    <p class="text-center font-bold my-2"><strong>B2 SWRGG and B3 SWLGG</strong></p>

<p><strong>1.4.2 Operation Speed</strong></p>
    <div class="overflow-x-auto my-4">
        <table class="w-full border border-gray-500 border-collapse text-sm">
            <tbody>
        <tr class="border-b border-gray-500">
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Horizontal Movement</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">0 – 25 m/min</td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Vertical Movement</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">1.5 m/min</td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Forward and reverse speed</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">< 0.4 m/s</td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Vertical drive speed</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">< 0.1 m/s</td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Cabin rotation speed</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">< 2°/sec</td>
        </tr>
        <tr class="border-b border-gray-500">
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Wheel steering speed</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">< 0.5 m/s</td>
        </tr>
        <tr>
            <td class="border-r border-gray-500 py-2 px-3 font-medium">Auto leveler vertical speed</td>
            <td class="py-2 px-3 text-right whitespace-nowrap">0.013 m/s</td>
        </tr>
            </tbody>
        </table>
    </div>

',
            '2.1 Power Supply' => '<p>The main electrical power source for Garbarata comes from the airport building which is divided according to the following main components:</p>
    <div class="overflow-x-auto my-4">
        <table class="w-full border border-gray-500 border-collapse text-sm">
            <tbody>
        <tr>
            <td class="border border-gray-500 py-2 px-3 font-medium">Drive power</td>
            <td class="border border-gray-500 py-2 px-3">380V</td>
            <td class="border border-gray-500 py-2 px-3">3-phase</td>
            <td class="border border-gray-500 py-2 px-3">50 Hz</td>
        </tr>
        <tr>
            <td class="border border-gray-500 py-2 px-3 font-medium">Lighting and Control power</td>
            <td class="border border-gray-500 py-2 px-3">220V</td>
            <td class="border border-gray-500 py-2 px-3">single phase</td>
            <td class="border border-gray-500 py-2 px-3">50 Hz</td>
        </tr>
        <tr>
            <td rowspan="2" class="border border-gray-500 py-2 px-3 font-medium">Air Conditioner power</td>
            <td class="border border-gray-500 py-2 px-3">380 VAC</td>
            <td class="border border-gray-500 py-2 px-3">3 phase</td>
            <td class="border border-gray-500 py-2 px-3">50 Hz</td>
        </tr>
        <tr>
            <td class="border border-gray-500 py-2 px-3">220 V</td>
            <td class="border border-gray-500 py-2 px-3">single phase</td>
            <td class="border border-gray-500 py-2 px-3">50 Hz</td>
        </tr>
            </tbody>
        </table>
    </div>',
            '2.2 Aktuator' => '<div class="overflow-x-auto my-4">
        <table class="w-full table-fixed border border-gray-500 border-collapse text-sm">
            <tbody>
        <tr>
            <td class="border border-gray-500 py-2 px-3 font-medium align-top break-words w-[34%]">Horizontal drive motor</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">5.5 kW</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">380VAC</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">3 Phase</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">50 Hz Cyclo drive</td>
        </tr>
        <tr>
            <td class="border border-gray-500 py-2 px-3 font-medium align-top break-words w-[34%]">Vertical drive motor</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">3.7 kW</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">380VAC</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">3 Phase</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">50 Hz Cyclo drive</td>
        </tr>
        <tr>
            <td class="border border-gray-500 py-2 px-3 font-medium align-top break-words w-[34%]">Cabin rotation motor</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">0.75kW</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">380VAC</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">3 Phase</td>
            <td class="border border-gray-500 py-2 px-3 align-top break-words">50 Hz Cyclo drive</td>
        </tr>
            </tbody>
        </table>
    </div>',
            '2.3 Pencahayaan ' => '<p>
        Garbarata is equipped with complete lighting, both interior and exterior,
        and added with emergency lights and operating lights. Details of the position of the lights are available
        in Chapter 7.
    </p>',
            '1.1 Deskripsi Detail Pengoperasian' => '<p>
        The settings for operating the Garbarata are located on the control console in the cabin which refers to the face plate layout for various controls such as indicators and annunciators. The following is an overview of some important controls:
    </p>

<figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/control_face_plate.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="Control Face Plate">
        <figcaption class="text-center mt-3 font-semibold">
            Control Face Plate
        </figcaption>
    </figure>

<p><strong>a. Telephone Socket</strong></p>

<p>
        The socket for the telecommunications cable is positioned on the desk console.
    </p>

<p><strong>b. Light Button</strong></p>

<p>
        Light button to turn on the Garbarata lights. Both interiors,
        exterior, as well as Garbarata obstruction.
    </p>

<p><strong>c. Emergency Stop</strong></p>button

<p>
        The Emergency stop button is on the control console and boogie wheel
        serves to stop the flow of electricity from the terminal to Garbarata. When
        the emergency stop button is pressed in manual and auto mode, then the Garbarata
        stops operating and is accompanied by a horn and buzzer sound.
    </p>

<p><strong>d. Power on and off button</strong></p>

<div class="overflow-x-auto my-6">
        <table class="w-full border border-gray-500 border-collapse text-sm">
            <tbody>
        <tr class="border-b border-gray-500">
            <td class="border border-gray-500 px-4 py-3 font-semibold w-1/4">
                On button
            </td>
            <td class="border border-gray-500 px-4 py-3">
                The power ON button activates all stand-by power for all motor controls and lights on the power indicator. Make sure the keyswitch is in the "OFF" position
            </td>
        </tr>

<tr>
            <td class="border border-gray-500 px-4 py-3 font-semibold">
                Off button
            </td>
            <td class="border border-gray-500 px-4 py-3">
                <p>i. After normal operation and the Garbarata returns to the predetermined/parked position, the power off button must be pressed. This will stop the energy/power on the machine, and control the power.</p>

<p class="mt-3">ii. In an emergency, the Emergency Stop button must be pressed immediately, this will turn off all electricity, except the lights.</p>
            </td>
        </tr>
            </tbody>
        </table>
    </div>

<p><strong>e. Keyswitch</strong></p>

<p>
        There are three keyswitch positions, namely off, manual and auto
    </p>

<div class="overflow-x-auto my-6">
        <table class="w-full border border-gray-500 border-collapse text-sm">
            <tbody>

<tr class="border-b border-gray-500">
            <td class="border border-gray-500 px-4 py-3 font-semibold w-1/4">
                Off
            </td>
            <td class="border border-gray-500 px-4 py-3">
                <ul class="list-disc pl-5">
                    <li>Garbarata is in stand-by condition</li>
                </ul>
            </td>
        </tr>

<tr class="border-b border-gray-500">
            <td class="border border-gray-500 px-4 py-3 font-semibold">
                Manuals
            </td>
            <td class="border border-gray-500 px-4 py-3">
                <ul class="list-disc pl-5">
                    <li>The manual indicator light will come on</li>
                    <li>All components of the aerobridge drive can be moved</li>
                </ul>
            </td>
        </tr>

<tr>
            <td class="border border-gray-500 px-4 py-3 font-semibold">
                Auto
            </td>
            <td class="border border-gray-500 px-4 py-3">
                <ul class="list-disc pl-5">
                    <li>The auto light will turn on</li>
                    <li>All manual movements will turn off</li>
                </ul>
            </td>
        </tr>

</tbody>
        </table>
    </div>
    <p><strong>f. Canopy Left or Canopy Right</strong></p>

<p>
        Two dead man type buttons work to control the right and left canopies for
        adjust the canopy position relative to the aircraft. If closing is not correct,
        (CANOPY DOWN indicator light remains on) The bridge cannot move forward
        forward because there is an interlock.
    </p>

<p><strong>g. Cabin Rotation</strong></p>button

<p>
        Two dead man type buttons are also used to control the rotary movement
        cabin to the right or left.
    </p>

<p><strong>h. Cabin Floor</strong></p>button

<p>
        The boarding bridge is equipped with a floor cabin that can be moved accordingly
        height requirements. Two cabin floor buttons that can be raised or
        lowered.
    </p>

<p><strong>i. Vertical Movement</strong></p>button

<p>
        Two push buttons, namely up and down, are used to raise or
        lowering the Garbarata.
    </p>

<p><strong>j. Horizontal Drive Control (Joystick)</strong></p>

<p>
        The 4-quadrant joystick control on Garbarata is used to move
        forward, backward, right and left. The joystick is spring loaded
        will return to neutral when released. As long as the joystick is moved in a direction
        front, or rear, the Garbarata speed will increase proportionally
        to the joystick position. Steering, left or right can be done sequentially
        in the direction of forward or backward movement.
    </p>

<p><strong>k. Touch Screen Display Indicator</strong></p>

<figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/touchscreen_display.png"
             class="mx-auto max-h-96 w-full object-contain rounded-lg"
             alt="Touchscreen Display">
        <figcaption class="text-center mt-3 font-semibold">
            Touchscreen Display
        </figcaption>
    </figure>

<ol class="list-lower-roman pl-6 space-y-4">

<li>
            <strong>Manual on/off:</strong> The Manual ‘ON’ indicator lights up when in position
            control keyswitch in manual mode for manual operation.
            Meanwhile, the MANUAL OFF indicator lights up when the keyswitch is in the position
            OFF or AUTO position.
        </li>

<li>
            <strong>Auto level on/off:</strong> By turning the keyswitch to the auto level position
            Turn on the autolevel indicator and the autolevel will come out.
        </li>

<li>
            <strong>Safety shoe:</strong> This indicator will light up if it is active in auto.
        </li>

<li>
            <strong>Maximum cabin rotation:</strong> This indicator lights up when the cabin reaches the limit
            maximum rotation.
        </li>

<li>
            <strong>Maximum travel:</strong> This indicator lights up when the tunnel reaches
            maximum horizontal elongation or shortening travel limit.
        </li>

<li>
            <strong>Vertical limit:</strong> This indicator lights up when the tunnel reaches the travel limit
            maximum vertical direction.
        </li>

<li>
            <strong>Maximum steering:</strong> This indicator lights up when wheel boogie reaches
            maximum steering limit.
        </li>

<li>
            <strong>Maximum swing:</strong> This will be indicated by a swing indicator light
            and an alarm will sound when the rotunda touches its rotation limit.
        </li>

<li>
            <strong>Service warning:</strong> The service warning indicator will light up when present
            error/alarm on Garbarata.
        </li>

<li>
            <strong>Autolevel warning:</strong> The indicator will light up when the system is autolevel
            works more than 4 seconds.
        </li>

<li>
            <strong>Bumper limit:</strong> This indicator will light up if the bumper comes into contact
            with the fuselage.
        </li>

<li>
            <strong>Canopy down:</strong> If the Canopy doesn\'t really go up/retract
            this will be illustrated by the “CANOPY DOWN” indicator light.
        </li>

<li>
            <strong>Slow down:</strong> This indicator lights up when the scanner sensor detects it
            fuselage about 1 m and/or before the bridge completely
            elongated or shortened.
        </li>

<li>
            <strong>Column fault:</strong> This indicator lights up and a warning buzzer sounds when
            The right and left lift columns are approximately 70 mm apart.
        </li>

<li>
            <strong>Safety Hoop:</strong> The indicator will light up if the safety hoop touches
            with foreign objects.
        </li>

<li>
            <strong>Tunnel slope:</strong> On negative or positive slope, the indicator will
            lights up when the tunnel hits its Slope Limit.
        </li>

<li>
            <strong>Video monitoring system:</strong> The video monitor displays totals
            image of wheel boogie. The operator can see which way the wheel is going
            directed and in which direction the Garbarata will move from its initial position.
        </li>

    </ol>',
            '2.1 Penggerak Horizontal' => '<p>
        When the POWER ON button is pressed (turned on) the PLC will activate and function
        regulate all voltages and controls on all Garbarata components.
        By turning the keyswitch to the manual position, power will flow throughout
        Garbarata components include horizontal drive.</p><p>
        Garbarata is a robotic machine that has many sensors for
        detect every movement. For example, when the Garbarata shortens
        maximum, then the bridge will no longer be able to be shortened, or when
        the garbarata is extended to the maximum, then the garbarata will no longer be available
        extended. When the bridge moves horizontally, automatically
        The rotary light and travel warning bell will light up as a warning to the crew
        other crews around Garbarata.</p><p><strong>Garbarata can move horizontally if :</strong></p><ol class="list-decimal pl-6">
        <li>There is no difference in the slope angle of the Garbarata and the floor in the rotunda</li><li>Canopy is folded</li><li>The vertical lift column is not active</li><li>Safety hoops are not obstructed by foreign objects</li><li>Is within the maximum horizontal rotation range</li><li>When the Garbarata is 2 meters from the fuselage, the Garbarata will automatically move slowly even if the joystick is pointed fully forward.</li></ol>

    <p class="mt-4"><strong>a) Moving Forward</strong></p><p>
        By moving the joystick forward it will move
        Garbarata towards the front, and simultaneously will accelerate the speed
        Garbarata. The aerobridge can be moved forward if it is not in position
        maximum length.</p><p><strong>b) Move backwards</strong></p><p>
        To move backwards or retract, point the joystick backwards /
        backwards and simultaneously accelerates. Garbarata can\'t
        moved backwards if it is not in the maximum short condition.</p><p><strong>c) Move left</strong></p><p>
        Point the joystick to the left and to the right, point the joystick
        towards the right.</p>',
            '2.2 Rotasi Kabin' => '<p>
        The cabin rotation button functions to move the cabin left or right.</p><p><strong>The cabin can be moved if :</strong></p><ol class="list-lower-roman pl-6">
        <li>The rotation buttons are not pressed simultaneously</li><li>The canopy is closed</li><li>is not in the maximum left or right position</li><li>The cabin does not touch the aircraft body</li></ol>

    <p>
        The cab can be rotated left or right using the cab rotation button
        on the control console.</p>',
            '2.3 Penggerak Vertikal' => '<p>
        The vertical drive functions to move the Garbarata vertically, with
        using the vertical up/down buttons on the control console.</p><p><strong>Garbarata can be moved vertically if:</strong></p><ol class="list-lower-roman pl-6">
        <li>The vertical up and down buttons are not pressed simultaneously</li><li>Garbarata is not in a maximum high or low position.</li><li>Canopy is perfectly folded</li><li>Garbarata is not moved horizontally</li>
    </ol>',
            '2.4 Penggerak Canopy' => '<p>
        The canopy functions as a barrier between the environment and the interior
        Garbarata while attached to the aircraft body. Canopy has
        right and left actuators. The canopy will attach to the fuselage on
        a certain pressure that is neither too low nor too strong.</p>',
            '3. Mode Auto (Autolevel)' => '<p>
        Auto mode is used to lock the Garbarata drive components which are not working
        used during the service process. When the keyswitch is in the Auto position, all
        Garbarata drive components will die.</p><p>
        Auto mode is only activated during the passenger loading and unloading process,
        When the process is complete, return the Garbarata to the parked position and turn it off
        all power and keyswitches are off.</p><p><strong>a. When the keyswitch is in the AUTO position, then :</strong></p><ul class="list-disc pl-6">
        <li>The horizontal drive function is not active</li><li>The vertical drive function is only active via the autolevel wheel (automatic)</li><li>In autolevel mode, the canopy system operates automatically</li><li>Cabin off rotation function</li><li>The autolevel indicator lights up</li><li>Cabin floor setting function is OFF</li></ul>

    <p class="mt-4"><strong>b. When a plane goes up or down, the following things happen:</strong></p><ul class="list-disc pl-6">
        <li>When the plane rises, sensors on the wheels light up. This regulates the PLC output to provide energy to the motor\'s vertical rise.</li><li>When the plane is descending, the sensors on the wheels turn on. This regulates the PLC output to energize the motor\'s vertical descent.</li><li>If the autolevel indicator and service warning indicator are on, an alarm will sound to alert the ground crew if a system failure occurs.</li><li>To turn off this alarm, one must turn the three position knob to the off/manual state.</li></ul>

    <p class="mt-4">
        <strong>When operating, make sure the Garbarata is under the intense supervision of the Garbarata operator</strong></p>',
            '4.1 Prosedur Pengoperasian Standar (Mode Manual)' => '<p><strong>a. Check and clean the Garbarata movement area of ​​any disturbing objects</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.1_a.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.a">
    </figure>

    <p><strong>b. Turn on the exterior and interior lights as well as the AC</strong>n</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.1_b.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.b">
    </figure>

    <p><strong>c. Console Control</strong>s</p><p>i. Make sure the keyswitch is in Off mode</p><p>ii. Press the Power On button and the On button light will turn on</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.1_c2.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.c2">
    </figure>

    <p>
        iii. Turn the keyswitch to manual mode, immediately after turning it into mode
        manual, a buzzer beep will sound.</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.1_c3.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.c3">
    </figure>

    <p><strong>d. Check the following components</strong></p><ol class="list-lower-roman pl-6 space-y-2">
        <li>
            The closure is fully folded, when the canopy lights are down
            If the condition is On, the Garbarata will not be able to be moved.</li><li>
            Autolevel is stationary.</li><li>
            Make sure there are no people along the tunnel, especially in the ramp area
            tunnels and meeting areas between tunnels.</li></ol>

    <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.1_d.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.d">
    </figure>

    <p>
        <strong>e.</strong> Use the Joystick to move the Garbarata forward or backward,
        Use the vertical drive and cabin rotation buttons to position
        Garbarata corresponds to the position of the aircraft.</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.1_e.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.e">
    </figure>

    <p>
        <strong>f.</strong> After the Garbarata touches the fuselage, adjust the cabin bumper
        with the airplane door. When the cabin bumper is close to the body
        aircraft, the Garbarata speed will automatically decrease.</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.1_f.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.f">
    </figure>

    <p><strong>g. Lower the Canopy Closure</strong>s</p>

    <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.1_g.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.g">
    </figure>
',
            '4.2 Prosedure Standar Operasi (Auto Mode)' => '<p><strong>a. Turn the keyswitch to the auto</strong>position</p><p>
        Note: When autolevel is on, all drives are on
        control console cannot work.</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_a.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.a">
    </figure>
    <p>
        <strong>b.</strong> Make sure the autolevel is in perfect contact with the fuselage. If
        Autolevel doesn\'t move perfectly, don\'t use aerobridge.
        fix the autolevel first.</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_b.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.b">
    </figure>
    <p><strong>c. Open the plane</strong>\'s door</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_c.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.c">
    </figure>
    <p><strong>d. Place the safety door shoe under the aircraft door</strong></p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_d.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.d">
    </figure>
    <p><strong>e. Once the process is complete, close the plane</strong>\'s door</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_e.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.e">
    </figure>
    <p><strong>f. Close the service door</strong></p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_f.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.f">
    </figure>
    <p><strong>g. Turn the keyswitch to the manual position</strong></p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_g.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.g">
    </figure>
    <p><strong>h. Fold the closure to its fullest extent</strong>s</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_h.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.h">
    </figure>
    <p><strong>i. Return the aerobridge to the parked position</strong></p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_i.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.i">
    </figure>
    <p><strong>j. Turn the keyswitch to off mode, and turn off the Garbarata and remove the key</strong>s</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_j.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.j">
    </figure>
    <p><strong>k. Press the off button to turn off the bridge</strong>s</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.2_k.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.k">
    </figure>
    <p><strong>l. Turn off lights and air conditioning when not in use</strong></p><p>
        <strong>Note :</strong> The emergency stop button is only used in emergencies.</p>',
            '4.3 Prosedur Pengoperasian Darurat' => '<p><strong>a. Over Swing</strong>s</p><p>
        The following explanation is the procedure if the Garbarata moves (swings)
        so far that it exceeds the maximum limit on the rotunda column.</p><ol class="list-lower-roman pl-6 space-y-4">
        <li>
            If the Garbarata moves too far and touches the limit sensor
            main switch, the Garbarata will automatically stop, for
            To return it, the Garbarata must be moved in the opposite direction.</li><li>
            If the Garbarata passes the main limit switch sensor then there is
            backup limit switch sensor (back up). When the Garbarata touches
            limit switch sensor back up, then the swing limit indicator will light up,
            and the service warning light will come on as well as the Garbarata
            will automatically turn off. To return it, Garbarata must
            moved back to parking position. When the Garbarata is in place
            in parking position, press the reset button to restore
            Bridge to normal operation. Immediately contact maintenance personnel
            to identify failure of the main limit switch in operation.</li></ol>

    <p class="mt-6"><strong>b. Over Steer</strong></p><p>
        The following procedure is carried out if Garbarata moves beyond the position
        steering range of motion.</p><ol class="list-lower-roman pl-6 space-y-4">
        <li>
            Under normal circumstances, if the operator moves the Garbarata in the direction
            right or left, when it reaches the maximum range then the limit switch
            which acts as a movement limiter will function.</li><li>
            Each limit switch has a back up limit switch which is a sensor
            backup when the main (initial) limit switch does not work.</li></ol>

    <p>
        When the main limit switch fails, the movement of the Garbarata will be restricted
        by the back up limit switch, and maximum steering and service indicators
        warning ON will sound.</p><p>
        The action that needs to be taken is to direct the Garbarata back to
        parking position, after press the reset button to restore
        Bridge to normal operation.</p><p>
        Immediately contact maintenance personnel to identify the failure
        main limit switch in operation.</p>
',
            '4.4 Parkir' => '<p>
        When parking Garbarata if wind gusts exceed 25 m/s,
        The aerobridge should be rotated so that the front part of its length is avoided
        from the wind, and make sure that the parts exposed to the wind
        minimized. The aerobridge should be shortened and lowered.</p><p class="mt-6"><strong>Note :</strong></p><ul class="list-disc pl-6 space-y-3">
        <li>
            To prevent strong winds from blowing into the cabin,
            The operator must always close the cabin door / rolling door when
            Garbarata is not operated. When the Garbarata returned to position
            parking, the operator must close the door and retract or rotate
            Garbarata away from the direction of the wind.</li><li>
            Do not leave empty aerobridges that are not in use
            the autolevel state sticks to the Plane. When the Garbarata does not
            used, then position the Garbarata according to the position of the aircraft.</li>
    </ul>
',
            '4.5 Penggunaan Jacking Stand' => '<p>
        In situations where Jacking Stands are needed for support
        Bridge or repair wheel boogie, follow these steps:</p><p><strong>4.5.1</strong> Raise the Garbarata to allow the Jacking Stand to be under the Garbarata support beams.</p><p><strong>4.5.2</strong> Place stands directly under support beams.</p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
        <img src="/images/modules/chapter3_4.5.2.png"
             class="mx-auto max-h-96 w-full object-contain rounded-lg"
             alt="Jacking Stand">
    </figure>
    <p>
        <strong>4.5.3</strong> Lower the bridge until the support beams are at the top
        jacking stand, and the stand (jack) stands firmly on the apron.
        Continue by holding the Down button to raise the wheel
        boogie from the ground for service.</p>',
            '4.6 Malfungsi Pergerakan atau Fault Power Garbarata' => '<p>
        In the situation of a power fault or other malfunction, it will be very
        affecting the movement of Garbarata. If the Garbarata has to be moved
        or withdrawn, below are the procedures that can be done
        followed if the warning and interlock do not work. Make sure that
        The boogie wheel does not rotate too much when doing it
        withdrawal. Columns should not be rotated more than 87.5 degrees from the line
        middle.</p><p><strong>The actuation procedure includes:</strong></p><p>
        <strong>4.6.1</strong> Install the tow rope in place on the drive column. Then
        Connect the towing rope to the eye hook plate on the column frame
        using shackles, then tighten the locking pin.</p><p>
        <strong>4.6.2</strong> Connect the end of the towing rope to the towing vehicle.</p><p>
        <strong>4.6.3</strong> Release the brake on the wheel boogie motor by turning
        brake knob clockwise on the motorbike.</p><p>
        <strong>4.6.4</strong> Pull the Garbarata slowly, do not pull the Garbarata
        violently or suddenly at high speed.</p><p>
        <strong>4.6.5</strong> Pull the Garbarata in the direction according to the wheel boogie position,
        do not forcefully pull the Garbarata in the opposite direction
        wheel boogie.</p><p>
        <strong>4.6.6</strong> The motorbike brake will function automatically as usual
        when the power returns to normal, but there is one safety suggestion,
        Lock the wheel boogie motorbike brakes again after you have finished pulling
        Garbarata by turning the brake knob counterclockwise.</p>',
            '4.1 Perawatan Garbarata' => '<p>Regular maintenance of the Garbarata will prevent damage and extend the life of the Garbarata. This
maintenance includes procedures for inspection, cleaning, painting, arrangement and one very
important procedure, namely the lubrication procedure. The lubrication procedure is very important.
The procedures presented in this chapter are highly recommended.</p>
<p class="mt-3">Overall maintenance must be carried out regularly to ensure all parts of the Garbarata are
functioning properly. Routine maintenance can also predict the duration of operation of Garbarata
parts and can also determine what kind of repairs are needed for various types of damage.</p>
<p class="mt-3">Use appropriate tools when carrying out repairs, settings and services to prevent damage, etc. Use a
clean water container when cleaning, rinsing and refilling lubricant for the gear box. Follow the
manufacturer\'s maintenance instructions contained in the manual attached to the components sold by
Bukaka. Clean up spills, dirt, or accumulations of debris from maintenance activities. Maintenance
must be carried out regularly every three months (quarterly).</p>
<div class="my-4 p-3 bg-amber-50 rounded-lg border border-amber-100 text-amber-800">
<strong>General Considerations:</strong>
<ul class="list-disc list-inside mt-1">
<li>(a) Only trained personnel work/operate the Garbarata</li>
<li>(b) Don\'t be hasty and careless in maintaining the Garbarata</li>
</ul>
</div>',
            '4.1.1 Karpet' => '<p>To keep the carpet clean, the cleaning schedule must be carried out as follows:</p>
<ul class="list-disc list-inside mt-2">
<li>(a) Clean the carpet every day</li>
<li>(b) Wash the carpet as often as possible with detergent-free shampoo</li>
</ul>',
            '4.1.2 Jendela' => '<p>Because the Garbarata is always exposed to the jet exhaust, a layer of dirt from the jet exhaust
will form on the Garbarata windows, therefore the windows must be cleaned every day. Use a
high-quality, detergent-free shampoo to clean the surface.</p>',
            '4.1.3 Dinding dan Ceiling Panel' => '<p>Walls and ceilings need regular cleaning. Use detergent-free shampoo to clean dirt.</p>',
            '4.1.4 Panel Dinding Kaca' => '<p>Glass walls must be cleaned carefully. Use a mild detergent-free shampoo to remove dirt. When
cleaning, the glass may shake.</p>',
            '4.1.5 Peralatan Penerangan' => '<p>Lens of lighting equipment such as lamps should be cleaned as often as possible with detergent-free
shampoo. Dry the entire fixture carefully before reassembling it.</p>',
            '4.1.6 Inspeksi Permukaan Luar' => '<p>It is recommended to check the painted exterior surface before dirt and lubricant residue react.
Periodic washing with a mild detergent will preserve painted tools and other equipment. Remove
debris and corroded material from the roof periodically. Pay more attention to the roof drain holes.
Once every half a year, use clean salt-free water and mild detergent to clean hydrocarbon oil
deposits from the Garbarata. This cleaning is part of a preventive maintenance program which
includes checking painted surfaces. If the paint shows signs of peeling or if rust is visible, then
the surface should be repainted as follows:</p>
<ul class="list-disc list-inside mt-2">
<li>(a) Use solvent to clean dirty or oily areas</li>
<li>(b) With fine sandpaper, clean the area to be repainted from rust, corrosion and peeling paint</li>
<li>(c) The first coat must be a high quality primer for metal</li>
<li>(d) Finish with two coats of polyurethane enamel to match the Garbarata color</li>
</ul>
<div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold">CAUTION: DO NOT PAINT MOVING PARTS SUCH AS CHAINS, SPROCKETS, SHAFT, BEARINGS, ROLLER OR RAILS.</div>',
            '4.2 Rotunda dan Tekanan Cabin Curtain' => '<p>The curtain can be checked by pressing the curtain from inside. The tension must be sufficient to
support the weight of passengers who may suddenly fall or trip on the curtain and to tighten the
curtain together when the cabin/rotunda rotates. Curtains that are too tense/tight will concave
outwards.</p>',
            '4.2.1 Penyetelan Tekanan Curtain' => '<p>If an inappropriate voltage is present on the Curtain from the winding on the Curtain barrel panel,
do the following:</p>
<ul class="list-decimal list-inside space-y-2 mt-2">
<li>
<strong>(a)</strong>Remove the rotunda curtain barrel cover from the top of the rotunda leading to the curtain coil. For
the cabin, open the hinged curtain barrel cover/cover so that the coils can be seen.</li>
<li>
<strong>(b)</strong> Position the bridge or cabin so that the curtain to be adjusted can be fully opened.</li>
<li>
<strong>(c)</strong>Rotate the bridge or cabin slowly so that the open curtain starts to roll. Turn the bridge in the
direction that the Curtain will fail to roll without manual assistance.</li>
<li>
<strong>(d)</strong>Without holding or pressing the Curtain, turn the worm gear counterclockwise for the left Curtain
and clockwise for the right Curtain, until the Curtain is pulled tightly on the coil.</li>
<li>
<strong>(e)</strong>Continue this procedure until the Curtain rotates from its open position to its rolled position
without any problems.</li>
<li>
<strong>(f)</strong> Rotate the bridge in both directions to ensure that the Curtain has suitable tension.</li>
</ul>
<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs">
<strong>NOTE:</strong>Sixteen turns of the coil are set at the factory. However, settings are made during installation and
these numbers may change.</div>
<div class="p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold text-xs uppercase">CAUTION: BEWARE OF HIGH PRESSURE HURT. BECAUSE THE COIL IS HIGH PRESSURE.</div>',
            '4.3 Drive Column dan Wheel Boogie' => '<p>Maintenance of the drive column and support legs (wheel boogie) is very crucial for the stability
and safety of up-and-down and back-and-forth movements of the Garbarata.</p>',
            '4.3.1 Inspeksi Vertikal Limit Switch' => '<p>Airbridge maintenance personnel must physically check the performance of the vertical upper and
lower limit switches on both drive columns every month. This can be done by moving the bridge up and
down, an assistant is needed to control the limit switch. Check one limit switch at a time. In
general, the bridge will stop by doing this. If one of the limit switches does not stop in vertical
movement, maintenance personnel must immediately replace it.</p>
<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs">
<strong>NOTE:</strong>If the limit column initial limit switch that is full up or full down moves (active) and at that
time the aerobridge experiences a power failure (power breaks/turns off) all upward movement will
stop after the power is cut. To regain control of the vertical movement, press the reset button at
the same time as moving the aerobridge in the opposite direction from its original position until
the limit switch is not active, now the vertical movement of the aerobridge will be normal as
before.</div>
<div class="p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold text-xs uppercase mb-4">CAUTION: A DAMAGED LIMIT SWITCH MAY RESULT IN DAMAGE TO THE DRIVE COLUMN AND LIFT COLUMN BEARINGS.</div>',
            '4.3.2 Bantalan Lift Column' => '<p>Oil-impregnated nylon-molybdenum pads function as column guides and prevent metal and metal from
touching. Each lift column has 8 bearings, 4 at the top and 4 at the bottom. One should check the
durability of the bearing once a year.</p>
<div class="overflow-x-auto my-4">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-center">PADS THICKNESS</th>
<th class="p-2 border border-gray-200 text-left">INDICATION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 text-center font-semibold">25 mm</td>
<td class="p-2 border border-gray-200 text-left">Thickness Initial</td>
</tr>
<tr class="bg-slate-50/50">
<td class="p-2 border border-gray-200 text-center font-semibold">23.5 mm</td>
<td class="p-2 border border-gray-200 text-left">Adjust the shims on the pads so they reach the original thickness.</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 text-center font-semibold">22 mm</td>
<td class="p-2 border border-gray-200 text-left">Replace pad</td>
</tr>
</tbody>
</table>
</div>
<p class="mt-3">These bearings are usually not always level, to overcome this problem, the bearings can be rotated
after 1.5 mm has been used up. Check the bearing base first, if the lower base is used because the
upper bearing must also be checked.</p>
<div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold text-xs uppercase mb-4">CAUTION: DO NOT TIGHTEN THE BOLT ON THE BEARING PLATE TOO TIGHT. LEAVE ROOM FOR THE CONE SPRINGS TO
ANTICIPATE THE LIFT COLUMN SHIFTING.</div>',
            '4.3.3 Inspeksi Ball Screw' => '<p>Lift column ball-screws must be lubricated and inspected after 5 years from service for excessive
corrosion, cracks, holes, depressions, or unusual wear of the ball grooves. After the first
inspection the ball screw must be checked every 5 years.</p>
<p class="mt-2">Lubricating and cleaning the ball screw can be done by raising and lowering the bridge from the
highest position to the lowest position at the same time while the lubricant is introduced through a
small funnel located under the lower column. Maintenance can clean the lift column once every 3
months.</p>',
            '4.3.4 Kekencangan Lift Column' => '<p>Check the bolts installed on the lift column and wheel boogie after a year of operation and tighten
the bolts to the recommended tightness as mentioned in the Fastener Torque diagram.</p>',
            '4.3.5 Rantai Boogie Drive' => '<p>Even if the chains are assembled correctly from the factory, they should still be checked regularly.
Replace parts of the chain that are loose, cracked or have other irregularities.</p>
<p class="mt-2">Discard the bad connector, replace it and connect it to the master link. Don\'t have any take-up
devices or gears that don\'t work and remain attached to the chain. When setting, follow the
instructions for chain tension, the minimum amount of bending/leaning of the chain must be the same
as the pitch of the chain itself, when the maximum bending of the chain is 3% of the total length.</p>',
            '4.3.6 Rem Cyclo Drive Motor' => '<p>Brakes on horizontal and vertical cycle drives work electro-mechanically and regular inspection and
servicing will ensure good performance. Brakes should be checked after one year of operation. To
check either vertical or horizontal drive brakes, maintenance crews need jacks.</p>
<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs mb-4">
<strong>NOTE:</strong> At each inspection, follow the steps described in the manual/guidebook attached to chapter 6.</div>
<div id="torque-diagram" class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-6 max-w-md mx-auto flex flex-col items-center">
<p class="text-[10px] font-bold text-slate-500 text-center mb-2">RECOMMENDED FASTENER TORQUE</p>
<img src="/images/modules/enhanced_diagram.png" class="w-full max-h-72 object-contain rounded-lg select-none" alt="Recommended Fastener Torque">
</div>',
            '4.3.7 Ban' => '<p class="font-bold text-slate-700 text-xs mb-2">HOW TO REMOVE A TIRE</p>
<ul class="list-decimal list-inside space-y-1.5 text-xs text-slate-600">
<li>
<strong>a)</strong> Raise the bridge on jacks/Jacking Stands.</li>
<li>
<strong>b)</strong> Hold the down button until the wheels touch the ground.</li>
<li>
<strong>c)</strong> Disassemble the chain guard and break the chain by removing the chain link.</li>
<li>
<strong>d)</strong> Remove the tapper bearing attached to the lockwasher, adjust the bearing and spacer.</li>
<li>
<strong>e)</strong> Carefully remove the assembly and sprocket assembly using a hammer from the back.</li>
<li>
<strong>f)</strong>Unscrew the 12 screws and bolts to dismantle the wheel axle, remove the tire beads and the outer
part of the wheel and dismantle these parts.</li>
<li>
<strong>g)</strong> Remember, the wheel bearings are currently open. The parts must be cleaned.</li>
<li>
<strong>h)</strong> Reassemble the installed wheel by reversing the order of the above procedures.</li>
</ul>
<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs">
<strong>NOTE:</strong> Tighten the 12 nuts and bolts attached to the wheel according to the rotation force table.</div>
<div class="space-y-6 mt-6 max-w-2xl mx-auto">
<div class="bg-gray-50 border border-gray-200 rounded-xl p-3 shadow-sm flex flex-col items-center">
<p class="text-[10px] font-bold text-slate-500 text-center mb-2">WHEEL ASSEMBLY</p>
<img src="/images/modules/enhanced_wheel_assembly.png" class="w-full max-h-64 object-contain rounded-lg select-none" alt="Wheel Assembly">
</div>
<div class="bg-gray-50 border border-gray-200 rounded-xl p-3 shadow-sm flex flex-col items-center">
<p class="text-[10px] font-bold text-slate-500 text-center mb-2">TIRE ASSEMBLY</p>
<img src="/images/modules/enhanced_tire_assembly.png" class="w-full max-h-64 object-contain rounded-lg select-none" alt="Tire Assembly">
</div>
</div>',
            '4.4 Roller Tunnel' => '<p>Study the entire description below before trying to adjust the Roller. This can make the roller
durable and prevent fatal damage.</p>',
            '4.4.1 Distribusi Bobot pada Roller' => '<p>At almost every level of position, fully retracted and extended, the LF (lower front) and UR (Upper
Rear) Rollers will support more weight. And when the aerobridge is fully extended in a flat/straight
position, part of the weight of the aerobridge is borne by the UF (Upper Front) and LR (Lower Rear)
rollers. When setting up the rollers, it is important to try to reduce the weight on the LF and UR
as much as possible.</p>
<div class="overflow-x-auto my-4">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left">DESCRIPTION</th>
<th class="p-2 border border-gray-200 text-left">POSITION</th>
<th class="p-2 border border-gray-200 text-center">ABBR.</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 text-left">Combination of Camroll and vertical thrust roller.</td>
<td class="p-2 border border-gray-200 text-left">Top back (right/left)</td>
<td class="p-2 border border-gray-200 text-center font-semibold">UR / UR</td>
</tr>
<tr class="bg-slate-50/50">
<td class="p-2 border border-gray-200 text-left">Combination of Camroll and vertical thrust roller.</td>
<td class="p-2 border border-gray-200 text-left">Back bottom (right/left)</td>
<td class="p-2 border border-gray-200 text-center font-semibold">LR / LR</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 text-left">Combination of Camroll and right vertical Roller</td>
<td class="p-2 border border-gray-200 text-left">Top front (right/left)</td>
<td class="p-2 border border-gray-200 text-center font-semibold">UF / UF</td>
</tr>
<tr class="bg-slate-50/50">
<td class="p-2 border border-gray-200 text-left">Unnecessary tandem roller thrust customized.</td>
<td class="p-2 border border-gray-200 text-left">Bottom front (right/left)</td>
<td class="p-2 border border-gray-200 text-center font-semibold">LF / LF</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 text-left">Roller lateral</td>
<td class="p-2 border border-gray-200 text-left">Bottom front (right/left)</td>
<td class="p-2 border border-gray-200 text-center font-semibold">LT / LT</td>
</tr>
<tr class="bg-slate-50/50">
<td class="p-2 border border-gray-200 text-left">Roller Stopper</td>
<td class="p-2 border border-gray-200 text-left">Bottom (right/left).</td>
<td class="p-2 border border-gray-200 text-center font-semibold">SL / SL</td>
</tr>
</tbody>
</table>
</div>
<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-6 max-w-md mx-auto flex flex-col items-center">
<p class="text-[10px] font-bold text-slate-500 text-center mb-2">ROLLER WEIGHT DISTRIBUTION</p>
<img src="/images/modules/enhanced_weight_distribution.png" class="w-full max-h-72 object-contain rounded-lg select-none" alt="Roller Weight Distribution">
</div>',
            '4.4.2 Pengaturan Vertikal Roller' => '<p>Extending and straightening the position of the bridge to release the weight on the LF roller
because the LF is vertical, there is no need to adjust it, thrust roller, this is a good place to
start.</p>
<ul class="list-none space-y-3 mt-2 text-xs text-slate-600">
<li>
<strong>(a) Measure the LR and LF rollers:</strong>
<ul class="list-disc list-inside ml-4 mt-1 space-y-1">
<li>(i) Remove access covers and weathering from these rollers.</li>
<li>(ii) Determine how the rollers UR and LR must be aligned to obtain the same distance between A & B,
and the same distance between C and D as shown in the Tunnel Cross Section figure.</li>
</ul>
<p class="ml-4 mt-1.5 font-semibold text-slate-700">Short bridge to remove load from UR roller:</p>
<ul class="list-decimal list-inside ml-8 mt-1 space-y-0.5">
<li>Pull the cover off this roller.</li>
<li>Remove the jam nuts that are stuck on the UR roller to clean the LR.</li>
<li>Tighten the bolts.</li>
<li>Retract one full turn on the UR bolt on the left side, tighten the jam nut.</li>
</ul>
</li>
<li>
<strong>(b) Extend the bridge slowly to transfer the weight to the UR roller:</strong>
<ul class="list-disc list-inside ml-4 mt-1 space-y-1">
<li>(i) Remove the access cover from the LR roller.</li>
<li>(ii) Remove the jam nut on the vertical adjustment bolt on the LR roller.</li>
<li>(iii) Adjust the roller so that the distance between A and B is the same as the distance between C
and D. Refer to the Tunnel Cross Section guide.</li>
</ul>
</li>
<li>
<strong>(c) Slowly shorten the bridge to shift the rear weight onto the LR roller:</strong>
<ul class="list-disc list-inside ml-4 mt-1 space-y-1">
<li>(i) Remove the jam nut on the vertical adjustment bolt on the UR roller.</li>
<li>(ii) Tighten these bolts until the roller is snug against the rail.</li>
<li>(iii) Retract the bolt one full turn.</li>
<li>(iv) Tighten the jam nut.</li>
</ul>
</li>
<li>
<strong>(d) Extend the bridge to move the weight on the UR and LF rollers:</strong>
<ul class="list-disc list-inside ml-4 mt-1 space-y-1">
<li>(i) Pull the access cover from the UF roller.</li>
<li>(ii) Remove the stuck jam nut and turn the vertical adjustment bolt on the UF roller until the
roller rests properly on the rail.</li>
<li>(iii) Back out the bolt one turn.</li>
<li>(iv) Tighten the nut.</li>
</ul>
</li>
<li>
<strong>(e)</strong>Run the bridge back and forth several times and check again the distance between A and B, C and D.
If after each row the distances are not the same as each other, repeat the setting procedure in the
step above.</li>
</ul>
<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-6 max-w-2xl mx-auto flex flex-col items-center">
<p class="text-[10px] font-bold text-slate-500 text-center mb-2">TUNNEL ROLLERS ADJUSTMENT</p>
<img src="/images/modules/b2_tunnel_rollers_adjustment_hd.png" class="w-full max-h-64 object-contain rounded-lg select-none" alt="Tunnel Rollers Adjustment">
</div>',
            '4.4.3 Pengaturan Horizontal Roller' => '<ul class="list-none space-y-3 mt-2 text-xs text-slate-600">
<li>
<strong>(a) Lengthen and straighten the bridge and remove all access covers:</strong>
<ul class="list-disc list-inside ml-4 mt-1 space-y-1">
<li>(i) Measuring from inside tunnel B, determine how the LR and LF rollers adjust to obtain the same
distance between E and F.</li>
<li>(ii) Measuring from outside tunnel B, determine how the rollers adjust to obtain the same distance
between G and H.</li>
</ul>
</li>
<li>
<strong>(b)</strong>Remove the jam nut on the horizontal adjustment bolt by backing out the UF roller enough to clear
the LT roller setting. Dimensions E and F must be the same.</li>
<li>
<strong>(c)</strong>Slowly shorten the bridge to shift the load on the LR and UF rollers. Remove the jam nut and back
out the UR roller enough to adjust the LR roller. Dimensions G and H must be the same.</li>
</ul>
<div class="my-4 p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold text-xs uppercase my-4">CAUTION: WHEN REMOVING THE UR AND UF ROLLER, DO NOT RETURN THEM MORE THAN NECESSARY TO SET LR AND
LT. REMOVING THIS ROLLER TOO MUCH COULD DAMAGE THE TUNNEL.</div>
<ul class="list-none space-y-3 text-xs text-slate-600">
<li>
<strong>(d) Slowly extend the bridge to move the weight of the UR and LF rollers:</strong>
<ul class="list-disc list-inside ml-4 mt-1 space-y-1">
<li>(i) Remove the jam nuts on the LR and LT rollers.</li>
<li>(ii) Turn the adjustment bolt on the LR and LT rollers in the direction of the moving tunnel to make
the distances G to H, and E to F the same. See sections A-A and C-C in the tunnel cross section
figure.</li>
<li>(iii) Tighten the opposite side bolts on the LR and LT rollers to cover the gaps from the
adjustments in the upper items.</li>
<li>(iv) With the distances G to H, and A to F the same, tighten each bolt until the roller rests well
on the rail, then back out each bolt one by one.</li>
<li>(v) Tighten the jam nuts.</li>
</ul>
</li>
<li>
<strong>(e) UF roller:</strong>
<ul class="list-disc list-inside ml-4 mt-1 space-y-1">
<li>(i) Tighten the UF-R roller until it rests on the rail well, then tighten the jam nut. See section
B-B of the tunnel cross section figure.</li>
<li>(ii) On the opposite side, tighten the UF-L roller until it rests well on the rail then back one
turn, tighten the jam nut. See section B-B of the Tunnel Cross Section figure.</li>
</ul>
</li>
<li>
<strong>(f) UR roller:</strong>
<ul class="list-disc list-inside ml-4 mt-1 space-y-1">
<li>(i) Shorten the bridge to shift the weight on the UR and UF rollers.</li>
<li>(ii) Tighten the UR-R roller until it rests well on the rail and tighten the jam nut. View the A-A
session on TCS.</li>
<li>(iii) On the reverse side, tighten the UR-L roller until it rests well on the rail and tighten the
jam nut.</li>
</ul>
</li>
<li>
<strong>(g)</strong>Move the bridge back and forth several times to check that E to F, G to G remain the same. A
tolerance of 3mm in each direction is fine.</li>
<li>
<strong>(h)</strong> Replace the access cover after checking the settings.</li>
</ul>
<p class="mt-4">After this setting, move the bridge back and forth several times while listening for any squeaks,
abnormal sounds or pops. If the tunnel is noisy, remove the bolt from the setting on the noisy
roller ¼ turn, and see if that fixes the problem. Continue by gently releasing the noisy roller
until the sound disappears. If you can\'t handle the right roller, do the reverse procedure,
releasing it on each turn.</p>',
            '4.5 Canopy Closure' => '<p>There are two kinds of differences in Frayed Closure materials:</p>',
            '4.5.1 Perbaikan Canopy Fabric' => '<p class="font-bold text-slate-700 text-xs mb-2">HOLE LESS THAN OR EQUAL TO 3 MM IN DIAMETER</p>
<ul class="list-none space-y-1.5 text-xs text-slate-600">
<li>
<strong>(i)</strong>Clean the area around the hole, both sides of the Fabric, with an alcohol base cleaner. Let it dry
completely.</li>
<li>
<strong>(ii)</strong> Use colored aluminum silicone for holes/frays and around them.</li>
<li>
<strong>(iii)</strong>Let the silicone dry for at least 60 minutes. Silicone working time is less than 10 minutes. Full
maintenance is normally 24 hours depending on weather and temperature.</li>
</ul>
<p class="font-bold text-slate-700 text-xs mt-4 mb-2">HOLE MORE THAN 3MM IN DIAMETER</p>
<p class="text-xs text-slate-600">Must be reinforced with a patch of base material measuring 25 mm wider than the hole in question.
The general procedure is as follows:</p>
<ul class="list-none space-y-1.5 text-xs text-slate-600 mt-2">
<li>
<strong>(i)</strong>Clean the area around the hole, both sides of the assembly, with an alcohol base cleaner. Let it dry
completely.</li>
<li>
<strong>(ii)</strong>Use colored aluminum silicone for the inner surface. The protected area must be 12 mm wider than the
hole/patch.</li>
<li>
<strong>(iii)</strong>Cover the area with a sheet of polyethylene (PE) film that is wider than the repaired area. Tighten
the film around all the<em>entrapped air</em>(trapped air). The silicone-free air should hold the polyethylene in place while working on the
outer canopy.</li>
<li>
<strong>(iv)</strong>Use the same amount of silicone for the outer surface while using polyethylene film as a backing on
the opposite side. Cover the outer layer of silicone with another sheet of PE film. Leave the film
for 60 minutes to dry. The processing time for this silicone is less than 10 minutes.</li>
<li>
<strong>(v)</strong>The film can be removed and the bridge can be operated after the silicone has completely dried. Full
drying normally takes 24 hours depending on weather and temperature.</li>
<li>
<strong>(vi)</strong>For larger holes, especially at the bottom crease, you may need clamping equipment to ensure good
filling. If a clamp is used, care must be taken not to spread the silicone more than the surface of
the PE film because the silicone will glue the two surfaces being pressed. Silicone will not stick
to PE film.</li>
</ul>',
            '4.5.2 Closure Limit Switches' => '<p class="text-xs text-slate-600 mb-2">To set the limit switch, follow these steps:</p>
<ul class="list-none space-y-1.5 text-xs text-slate-600">
<li>
<strong>(a)</strong> Raise the closure all the way up.</li>
<li>
<strong>(b)</strong> Remove the bolts on the <em>lower tie-bar arm</em>.</li>
<li>
<strong>(c)</strong>Arrange the bolts up or down so that the wheel on the limit switch arm is in the middle of the
bearing.</li>
<li>
<strong>(d)</strong>Remove the Allen screw on the limit switch arm and set the arm wheel with a gap between the wheel
and the bearing is 3 to 6 mm.</li>
</ul>
<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs">
<strong>NOTE:</strong>
<ul class="list-none space-y-1 mt-1">
<li>
<strong>(i)</strong> This will complete the adjustment to the stop limit.</li>
<li>
<strong>(ii)</strong> The latest version of Garbarata is provided with what is called a <em>pressure relief limit switch</em>, attached directly below the stop limit switch.</li>
<li>
<strong>(iii)</strong>If the limit switch is installed, adjust the pressure relief limit switch, namely the arm wheel
rests on the stop limit switch.</li>
</ul>
</div>
<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-6 max-w-md mx-auto flex flex-col items-center">
<p class="text-[10px] font-bold text-slate-500 text-center mb-2">CANOPY ARM ADJUSTMENT</p>
<img src="/images/modules/canopy_arm_adjustment.png" class="w-full max-h-72 object-contain rounded-lg select-none" alt="Canopy Arm Adjustment">
</div>',
            '4.6.1 Pemeriksaan Harian untuk Operator' => '<p>Study the daily inspection guide below to maintain the operational condition of the Garbarata
bridge.</p>
<h4 class="font-bold text-slate-800 text-xs mt-6 mb-2">4.6.1 Daily Checks for Operators</h4>
<ul class="list-none space-y-3 text-xs text-slate-600">
<li>
<strong>(a)</strong> Operators should check the <em>auto level</em>every morning. Move the wheel by hand, up and down, the drive column will move accordingly. Note
that the movement can rotate freely and the springs return to their neutral position. Check the
tightness of the screws that hold the shaft and also check whether the switch really sticks. Wheel
switch failure can damage the aircraft.</li>
<li>
<strong>(b)</strong>Operators must also check the operation of the bridge, especially the autolevel system and limit
switch distance control. Report any malfunctions to the maintenance department.</li>
<li>
<strong>(c)</strong>Operators must check the aerobridge directly, especially for missing or used hardware, peeling
paint, dust and corrosion, oil leaks, damaged or bad component arrangements. Problem areas should be
reported to the maintenance department.</li>
</ul>
<div class="my-4 p-3 bg-amber-50 rounded-lg border border-amber-100 text-amber-900 text-xs">
<strong>Leveler Damage Prevention Measures:</strong>
<ul class="list-none space-y-1 mt-1">
<li>
<strong>(i)</strong> Avoid rough treatment of the leveler.</li>
<li>
<strong>(ii)</strong> Do not try to turn the wheel on the shaft.</li>
<li>
<strong>(iii)</strong> Do not use the wheel as a footrest.</li>
<li>
<strong>(iv)</strong> Never force a mechanical stop.</li>
<li>
<strong>(v)</strong>Any shims that were removed or that may have fallen off during the maintenance process must be
replaced before re-securing the limit switch.</li>
</ul>
</div>',
            '4.6.2 Pelumasan' => '<h4 class="font-bold text-slate-800 text-xs mt-6 mb-2">4.6.2 Lubrication</h4>
<ul class="list-none space-y-3 text-xs text-slate-600">
<li>
<strong>(a)</strong>Lubrication is the most important part of the preventive maintenance program and this part must be
done using a checklist. The calculations in this section are for several points that require
lubrication. Lubrication table specifications describe lubricating oils and their uses.</li>
<li>
<strong>(b)</strong>Only qualified technicians should lubricate the bridge. They must understand the requirement of
\'adequate lubrication\', namely not excessive lubrication.</li>
</ul>
<div class="overflow-x-auto my-4">
<p class="text-[10px] font-bold text-slate-500 mb-1.5 uppercase">Table 5-1: Lubricants Specification</p>
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-center">No.</th>
<th class="p-2 border border-gray-200 text-left">SPECIFICATION</th>
<th class="p-2 border border-gray-200 text-left">PRODUCER</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 text-center font-semibold"># 1</td>
<td class="p-2 border border-gray-200 text-left">UG-857 HEAVY DUTY BEARING LUBRICANT or similar, such as BEACON 2 or LOTUS 777 AR.</td>
<td rowspan="3" class="p-2 border border-gray-200 text-center align-middle bg-slate-50/50">Pertamina, Shell, Mobil, Exxon, Lotus, Castrol or similar.</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 text-center font-semibold"># 2</td>
<td class="p-2 border border-gray-200 text-left">EP EXTREME PRESSURE CHAIN LUBRICANT or similar, such as ALMAS COAT 2C or ROCOL.</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 text-center font-semibold"># 3</td>
<td class="p-2 border border-gray-200 text-left">WATERPROOF EXTREME PRESSURE OPEN GEAR LUBRICANT or similar, such as MOBILTAC YY or ROCOL M27.</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 text-center font-semibold"># 4</td>
<td class="p-2 border border-gray-200 text-left">GENERAL MOTORCYCLE LUBRICANT or similar, such as SAE 10W-30 or ROTELLA.</td>
<td class="p-2 border border-gray-200 text-center bg-slate-50/50">Pertamina or similar.</td>
</tr>
</tbody>
</table>
</div>
<div class="grid grid-cols-1 gap-6 my-6">
<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm flex flex-col items-center">
<p class="text-[10px] font-bold text-slate-500 text-center mb-2">CANOPY ARM ADJUSTMENT</p>
<img src="/images/modules/canopy_arm_adjustment.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="Canopy Arm Adjustment">
</div>
<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm flex flex-col items-center">
<p class="text-[10px] font-bold text-slate-500 text-center mb-2">WHEEL BOOGIE ASSEMBLY</p>
<img src="/images/modules/enhanced_wheel_boogie_assembly.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="Wheel Boogie Assembly">
</div>
<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm flex flex-col items-center">
<p class="text-[10px] font-bold text-slate-500 text-center mb-2">CABIN ROTATION SYSTEM</p>
<img src="/images/modules/enhanced_cabin_rotation.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="Cabin Rotation System">
</div>
<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm flex flex-col items-center">
<p class="text-[10px] font-bold text-slate-500 text-center mb-2">ROTUNDA ASSEMBLY</p>
<img src="/images/modules/rotunda_hd.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="Rotunda Assembly">
</div>
</div>',
            '4.6.3.1 AUTO LEVEL' => '<p class="text-xs text-slate-600 leading-relaxed mb-4">To ensure safe GARBARATA operations, the Maintenance Department Team must inspect the Passenger
Boarding Bridge regularly by operating all existing functions and systems, on a monthly scale
referring to the Monthly Inspection Table below. Local conditions also play a role in determining
the exact details of the most efficient and effective maintenance program.</p>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">MONTHLY INSPECTION POINTS</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>1.</strong> Check all screws holding the wheel to the Limit Switch. Both must always be tight.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>2.</strong>Turn the wheel by hand in both directions to ensure free movement when engaged and ensure the wheel
returns to the neutral position. This will correspond to the Limit Switch.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>3.</strong> Check the Arm, this Arm must move freely in both directions.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>4.</strong>Turn all three Switch positions to Auto and check the running of the Autolevel Limits against the
Arm extension. After approximately 3 seconds an Error Message, Buzzer and Alarm will appear
indicating the Autolevel wheel is not in contact with the aircraft. To stimulate normal operation,
stop the Arm in the position before PX6 and PX7 engage.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>5.</strong>Rotate and hold the wheel with your hand to stimulate the plane to rise. After approximately 6
seconds, the Autolevel warning light illuminates and the alarm sounds.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>6.</strong>Reset the Autolevel system and check down travel by turning and holding the Wheel Counter clockwise.
Approximately 6 seconds, the warning light comes on and the alarm sounds.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>7.</strong>Put the autolevel switch selector to the OFF position and check that the alarm and buzzer should
immediately stop sounding.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.6.3.2 LIMIT SWITCH DAN OPERASI DETEKTOR' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">MONTHLY INSPECTION POINTS</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>1.</strong>Slowly move the Garbarata passenger boarding bridge, operate the limit switch by hand and verify the
following system is working correctly:<br>
<span class="pl-4 inline-block">a. Cab rotation limit warning (Right/Left)</span>
<br>
<span class="pl-4 inline-block">b. Extreme cabin rotation limit warning (Right/Left)</span>
<br>
<span class="pl-4 inline-block">c. Limit switch slowdown forward and reverse</span>
<br>
<span class="pl-4 inline-block">d. Limit switch stop forward and reverse</span>
<br>
<span class="pl-4 inline-block">e. Limit switch slowdown up and down</span>
<br>
<span class="pl-4 inline-block">f. Limit switch stop up and down</span>
</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>2.</strong> Limit Switch slow down; forward and backward directions.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>3.</strong> Infrared Scanner run slowly; forward and backward.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>4.</strong> Spacer Limit aircraft; just go forward.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>5.</strong> Boogie maximum steering; right and left.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>6.</strong> Top and bottom canopies; right and left.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>7.</strong> Limit Switch vertical direction; up and down.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>8.</strong> Slope Limit; down (up - option).</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>9.</strong> Maximum cabin rotation; right and left.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>10.</strong> Cabin floor leveling; up and down.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>11.</strong> Maximum movement of the rotunda; right and left.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-3 p-3 bg-blue-50/50 text-blue-800 text-[11px] border border-gray-100 rounded-lg">
<strong>NOTE:</strong>
<br>a. Check only one Limit Switch at a time.<br>b. All movements should be done slowly if operation feels rough and noisy, check for interference on
the Roller Tracks.</div>',
            '4.6.3.3 PERIKSA BAN' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">MONTHLY INSPECTION POINTS</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>1.</strong> Check the general condition of the tires.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>2.</strong> Check the tightness of the bolts on the rim, if they are loose, tighten them using a torque wrench.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.6.3.4 DETAIL KESELURUHAN' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">MONTHLY INSPECTION POINTS</th>
<th class="p-2 border border-gray-200 text-center w-1/4">COMMENTS</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>1.</strong>Check the Equalizing cable hooks on the three Tunnels in the Garbarata and the condition of the
Steel Cable.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>2.</strong>All exterior surfaces are painted and must always be clean of dirt and oil, especially on hinges,
Limit Switches, etc.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>3.</strong> Check the paint for peeling chips, cracks, and rust. Touch-up if necessary.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.6.4.1 ROTUNDA' => '<p class="text-xs text-slate-600 leading-relaxed mb-2">This section relates to the inspection program for the operation and oiling of Garbarata so that it
can be fulfilled every three months. The work must be scheduled from start to finish without
interruption. This will ensure that no steps are overlooked due to lack of care.</p>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following graphic is for reference only, local conditions will determine the appropriate details
for an effective and efficient Maintenance program.</p>
<p class="text-[11px] font-bold text-slate-700 uppercase tracking-wide mb-2 mt-4">Part 1: Operations & Functions</p>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>1.</strong>Manipulate the following Limit Switches using your hands, make sure the Limit Switch is functioning
properly:<br>
<span class="pl-4 inline-block">a. Rotunda</span>rotation<br>
<span class="pl-4 inline-block">b. Slope Border</span>
</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>2.</strong> Check the tightness of the Rotunda Side Curtains, adjust if necessary.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.6.4.2 KABIN' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>1.</strong> Check the cabin rotation, fully rotate the cabin to the right and left. Operation should be slow.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>2.</strong> Check the Closure function:<br>
<span class="pl-4 inline-block">a. Lower both right and left Canopy Canopies at the same time, open the extended closure completely
until you hear a click. The canopy moves down and the bridge will not move forward.</span>
<br>
<span class="pl-4 inline-block">b. Raise both right and left canopies. The motor will stop working when the Closure is fully raised.</span>
</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>3.</strong> Check the tightness of the Curtain on the side of the cabin and adjust if necessary.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>4.</strong> Check Cab Side including electrical cables for damage and general condition.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>5.</strong> Lift Column Vertical Error on Limit Switches (Check only one limit switch at a time):<br>
<span class="pl-4 inline-block">a. Manually operate the limit switch while another person works to raise and lower the Garbarata. If
the bridge continues to rise or fall, the limit switch is damaged and must be replaced.</span>
<br>
<span class="pl-4 inline-block">b. Repeat this procedure on the other Limit Switch.</span>
</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-3 p-3 bg-blue-50/50 text-blue-800 text-[11px] border border-gray-100 rounded-lg">
<strong>NOTE:</strong>All Limit Switch shims/chops that vibrate or are released or that fall during any process must be
replaced before tightening all limit switches.</div>',
            '4.6.4.3 SAMBUNGAN LISTRIK' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td colspan="2" class="p-2 text-slate-500 font-semibold italic border border-gray-200 bg-slate-50/30">Check the operator\'s Control Console, Power Panel and Main Electrical Panel:</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>1.</strong> All PCBs, Cable Networks and Electrical Arrays for loose connections.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>2.</strong> Clean areas of frequent contact with contact cleaner.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>3.</strong> Check for moisture, rust and debris.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>4.</strong> Check for all signs of warping or loose joints.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.6.4.4 AUTOLEVEL' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>1.</strong> Check all screws holding the wheel to the limit Switch. Both must always be tight.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>2.</strong>Turn the wheel by hand in both directions to ensure free movement when engaged and ensure the wheel
returns to the neutral position. This will correspond to the Limit Switch.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>3.</strong> Check the Arm, this Arm must move freely in both directions.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>4.</strong>Turn all three Switch positions to Auto and check the Autolevel limits against the extended Arm.
After approximately 3 seconds an Error Message, Buzzer and Alarm will appear indicating the
Autolevel wheel is not in contact with the aircraft. To stimulate normal operation, stop the Arm in
the position before PX6 and PX7 engage.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>5.</strong>Rotate and hold the wheel with your hand to stimulate the plane to rise. After approximately 6
seconds, the Autolevel warning light illuminates and the alarm sounds.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>6.</strong>Reset the Autolevel system and check down travel by turning and holding the Wheel Counter clockwise.
Approximately 6 seconds, the warning light comes on and the alarm sounds.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-3 p-3 bg-blue-50/50 text-blue-800 text-[11px] border border-gray-100 rounded-lg">
<strong>NOTE:</strong>The Auto Level timer is set by the Internal Counter Program via the Programmable Logic Controller.
Press the Emergency button while in Auto mode to check whether the alarm can be heard properly.</div>',
            '4.6.4.5 PEMERIKSAAN BAN-BAN' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>1.</strong> Check the overall condition of the tires.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>2.</strong> Check the tightness of the bolts on the rim, if they are loose, tighten them using a torque wrench.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.6.4.6 KONDISI UMUM DARI EXTERIOR DAN PELAPIS CUACA' => '<p class="text-[11px] font-bold text-slate-700 uppercase tracking-wide mb-2 mt-6">Part 2: Structure, Weatherproofing & Periodic Lubrication</p>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>1.</strong> Equalizing Cable (for three Tunnel bridges only):<br>
<span class="pl-4 inline-block">a. Check Wire Rope Equalizing cables in the tunnel, and adjust if necessary.</span>
<br>
<span class="pl-4 inline-block">b. Check the tightness of the Turnbuckles of the Equalizing Cable and the condition of the Steel
Cable.</span>
</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>2.</strong> Cable carrier or holder / Cable Scissor:<br>
<span class="pl-4 inline-block">a. Check the tightness and condition of the base/bottom cable, retaining cable and base/bottom cable
rail.</span>
<br>
<span class="pl-4 inline-block">b. Check all cables for damage.</span>
</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>3.</strong> Check the tightness and condition of all terminals in the Junction Box under the tunnel.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>4.</strong> Check the condition of all weather stripping, repair or replace if necessary.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>5.</strong> Check all tunnel rollers and bearings, all up and down movements must be linear and smooth.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>6.</strong> Check the paint for peeling chips, cracks, and rust. Touch-up if necessary.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>7.</strong> Check the glass walls for peeling and cracks.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>8.</strong> Check the bolts on the horizontal motor and Lift Column, make sure they are all tight.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.6.4.7 ROTUNDA (LUMAS!)' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>a.</strong> Rotunda Column Flange and Bearings Sleeve with No. lubricant. 1.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>b.</strong> Curtain Pillow Blocks and Worm Gears on both sides of the Rotunda with No. lubricant. 2.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>c.</strong> Rotunda Hinge with No. lubricant. 3.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.6.4.8 TUNNELS' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>a.</strong> System parts for 3 Tunnel Equalize Cable with lubricant No. 2:<br>
<span class="pl-4 inline-block">(i) Sheave Rods</span>
<br>
<span class="pl-4 inline-block">(ii) Tension Rod Cable</span>
<br>
<span class="pl-4 inline-block">(iii) Cable Guide Rollers (Guides)</span>
</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>b.</strong>Check the tightness of the Turnbuckles of the three Garbarata tunnels and the condition of the Steel
Cables.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>c.</strong> All Roller units with No. lubricant. 4.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.6.4.9 VERTICAL COLUMN' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>a.</strong>Raise the Garbarata to the maximum to lubricate and clean the Ball Screw with lubricant No. 1 if
necessary.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>b.</strong> Bearings in the Vertical Lift Column at each connection above each Column using lubricant No. 1.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>c.</strong> Vertical Motor with lubricant No. 4.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.6.4.10 WHEEL BOOGIE' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>a.</strong> Thrust Bearing with lubricant No. 1.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>b.</strong> Bushing and Trunnion Pin with lubricant No. 1.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>c.</strong> Drive chains on Wheel Boogie with No. lubricant. 2.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>d.</strong> Horizontal Motor with lubricant No. 4.</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-3 p-3 bg-blue-50/50 text-blue-800 text-[11px] border border-gray-100 rounded-lg">
<strong>NOTE:</strong>The bearings on the wheels must also be lubricated when the wheel components are removed with
lubricant No. 1.</div>',
            '4.6.4.11 KABIN (LUMAS!)' => '<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-3/4">INSPECTION POINTS QUARTAL</th>
<th class="p-2 border border-gray-200 text-center w-1/4">DESCRIPTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200">
<strong>a.</strong> Mechanical Components in Cabin Closure with lubricant No. 3:<br>
<span class="pl-4 inline-block">(i) Actuator pivot point.</span>
<br>
<span class="pl-4 inline-block">(ii) Actuator arm bushings.</span>
<br>
<span class="pl-4 inline-block">(iii) Pivot block.</span>
<br>
<span class="pl-4 inline-block">(iv) Support Hinge.</span>
</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200">
<strong>b.</strong> Rotating parts in the Cabin:<br>
<span class="pl-4 inline-block">(i) Drive chains, lubricant No. 3</span>
<br>
<span class="pl-4 inline-block">(ii) Sprocket Shafts, lubricant No. 3</span>
<br>
<span class="pl-4 inline-block">(iii) Cabin Curtain pillow block and worm gears on both sides of the cabin with No. lubricant. 2.</span>
</td>
<td class="p-2 border border-gray-200">
</td>
</tr>
</tbody>
</table>
</div>',
            '4.7 Panduan Troubleshooting' => '<p class="text-xs text-slate-600 leading-relaxed mb-4">The troubleshooting manual is created as a reference for adequate maintenance and repair. The tables
contain common problems, possible cases and all corrective actions. This manual was created for
technicians who are qualified to solve problems that may arise.</p>
<p class="text-xs text-slate-600 leading-relaxed">These instructions can be the best guide and overview of maintenance in the field as well as
maintaining good maintenance. This manual covers, minor repairs, adjustments, problem locations and
replacement of damaged components. Replacement, installation, overhead and repair of each component
will be explained in subsections of this manual.</p>
<p class="text-xs font-semibold text-blue-600 mt-4">
<em>*Click on each TROUBLE title below to see a detailed table of causes and corrective actions.</em>
</p>',
            '4.7.1 TROUBLE 1' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 1</h5>
<p class="text-xs mt-1">Keyswitch is in the OFF position and the button power is in the ON position, but there is no power
to the main circuit and control circuit.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECT ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">No power from Terminal</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the power center, if OFF, check the electricity with a multitester.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check MCCB1, MCCB2, ELCB1 and MCB1. If Tripped, turn it on.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check the voltage on the 380VAC and 220VAC lines with a multi tester.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">ELCB1 open</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Position ELCB1 to \'ON\'. If Tripped, check the error warning for loose connections or other
possibilities. Fix.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Emergency button pressed or not working</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Reset the Emergency Button.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Electricity may flow to the inlet of the emergency button, but not to the outlet. Broken button.
Replace Button.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">POWER-ON button doesn\'t work</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Electricity may flow at the inlet of the button, but not at the outlet. Broken button. Replace
Button.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">6</span>
<span class="flex-1">Electrical Conducting Component RL2 does not work</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the coil and connectors. Replace if necessary/damaged.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">7</span>
<span class="flex-1">MCB2 in control console unit for open control circuit</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Turn on MCB2. If it trips again, check for cables, loose connections, or other problems, fix the
problem.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">8</span>
<span class="flex-1">Keyswitch not working</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the keyswitch, if it doesn\'t work, replace it.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">9</span>
<span class="flex-1">Switch power supply inoperable</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the DC output voltage of the switching power supply module. Also check the fuse. If damaged,
replace.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.2 TROUBLE 2' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 2</h5>
<p class="text-xs mt-1">Garbarata not responds to Vertical movement commands in Manual Mode.</p>
</div>
<div class="bg-blue-50 text-blue-900 p-3 rounded-lg border border-blue-100 text-xs mb-4">
<strong>NOTE (NOTE) - In this condition, make sure that:</strong>
<ul class="list-decimal pl-4 mt-1.5 space-y-1">
<li>The Power-ON button lights to ensure that power/electricity is flowing to the unit.</li>
<li>The Canopy is in the fully retracted position and the Canopy DOWN button indicator is not lit.</li>
<li>Keyswitch button is in MANUAL condition.</li>
<li>The aerobridge does not completely retract or extend, this means the Limit Switch Tunnel condition
is not active.</li>
<li>The Garbarata position is not in the highest or lowest state, this means that the Limit Switch on
the Drive Column is not active.</li>
<li>The MCCB4 power panel on the motor Panel Box is ON.</li>
<li>Both Drive Columns (left and right) are balanced/parallel, in this state Fault Limits/Column faults
are not active.</li>
</ul>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Circuit control inactive</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check MCCB4. If it goes down, turn it on again.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check OL1 and OL2 overheating. If Tripped, reset.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check the buttons for Vertical Up/Down movement on the Control Console table. If it doesn\'t work,
replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check Limit Switches LS9, LS10, LS11, LS12 and their cables. If it does not work, repair or replace
if necessary.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check magnetic contacts C4 and C5, if not working, replace.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">6</span>
<span class="flex-1">Check interlock systems PX1, LS3A, LS3B, LS4A and LS4B. If it doesn\'t work repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">7</span>
<span class="flex-1">Check the cables, replace them if damaged.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">8</span>
<span class="flex-1">Check the Power Supply, if it doesn\'t work, repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">9</span>
<span class="flex-1">Check Keyswitch. If it doesn\'t work repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">10</span>
<span class="flex-1">Check the pilot light, if the service warning light is flashing check the error code in the Console
Desk and fix the problem then reset.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Vertical motor right or left is not active</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the incoming mains voltage. If possible check the motor. Repair or replace the motor.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Program not working or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Please contact PT. OPEN THE MAIN TECHNIQUE to send a new program to replace the old one.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Ball Screw not working</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check rotation tolerance, correct if necessary.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Mechanical Brake does not operate</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check Mechanical Brakes.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Repair or replace the magnetic coil for the brake motor.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">See the instruction manual for the motor.</span>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.3 TROUBLE 2.1' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 2.1</h5>
<p class="text-xs mt-1">Vertical Drive Excess trip before reaching the correct altitude limit.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Full, all three phases do not supply power to the motor.</span>
</div>
</td>>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">In the motor power panel, check the overload heater OL1 and OL2 on the Vertical Drive contacts.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check the vertical Drive contactors C4 and C5.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Ball Screw stopped or stuck</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check rotation tolerance, correct if necessary.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Mechanical Brake does not operate</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check Mechanical Brakes.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Repair or replace the magnetic coil for the brake motor.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">See the instruction manual for the motor.</span>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.4 TROUBLE 2.2' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 2.2</h5>
<p class="text-xs mt-1">Garbarata cannot go down even though other systems are working, while the position is in manual
mode.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control Circuit inoperative</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the Vertical \'Down\' Button on the Console table. If it is not active, repair or replace it
and check the unit\'s PLC input sequence.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the coils and connections of the CS magnetic connector (C5). If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check Limit Switch for Vertical Down, LS9, 10, 11, 12. If not working, replace.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check Limit Switches for Interlock System, LS3B, LS4B and PX1.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check the Voltage output from the Switching Power Supply, the result should be 24VDC. If not repair
or replace.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">6</span>
<span class="flex-1">Check all cables, if damaged, replace them.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">7</span>
<span class="flex-1">Check Link Terminal (TX2). Input to Junction Box C2.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">The ladder program is inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. BTU to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.5 TROUBLE 2.3' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 2.3</h5>
<p class="text-xs mt-1">Brake for vertical drive motor does not work</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Cable network error</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the braking circuit.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check all cables, replace if damaged.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check all varistors for rapid braking. If it doesn\'t work, replace it.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Mechanical Brake does not operate</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check Mechanical Brakes.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Repair or replace the magnetic coil for the brake motor.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">See the instruction manual for the motor.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">The brakes are not installed properly</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Refer to the instruction manual for installing the brakes.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">The lubricant or oil is on the brake disc</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Clean with cleaner.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Varistor (Vanistor) for bad fast brakes.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the varistor. If it\'s not good, replace it (it\'s inside the Motor Power Panel).</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.6 TROUBLE 2.4' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 2.4</h5>
<p class="text-xs mt-1">Garbarata cannot be raised or lifted even though other systems are working.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control Circuitry is not operational.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the Vertical \'Up\' Button on the Console table. If it is not active, repair or replace it and
check the unit\'s PLC input sequence.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the coils and connections of magnetic connector C4.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check Limit Switch to move Vertical Up, LS9, LS10, LS11, LS12.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check Limit Switches for Interlock System, LS3A and LS4A.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check the Voltage output from the Switching Power Supply, the result should be 24VDC. If not repair
or replace.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">6</span>
<span class="flex-1">Check all cables, if damaged, replace them.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">The ladder program is inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. OPEN MAIN TECHNIQUES to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.7 TROUBLE 3' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 3</h5>
<p class="text-xs mt-1">Cabin cannot rotate</p>
</div>
<div class="bg-blue-50 text-blue-900 p-3 rounded-lg border border-blue-100 text-xs mb-4">
<strong>NOTE :</strong>Based on our experience, damage to the motorbike, brake system, gears and chain system is very rare.
This system is designed with high durability and will not cause problems</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Circuit Control not working</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check MCCB5. If Tripped, turn \'ON\' once again.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check Thermal Overload relay OL3. If Tripped, reset.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check the Cabin Rotation button on the Console table, if it doesn\'t work, repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check Contactor for Cabin Rotation C6 and C7. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check Limit Switches LS17B, LS17A, LS18A, LS18B. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">6</span>
<span class="flex-1">Check Limit Switches for LS19, LS20, LS23, LS24 and LS-25 system interlocks. If it doesn\'t work,
replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">7</span>
<span class="flex-1">Check the cables in the Circuit for the Motor Drive Cab. If any cables are not connected, repair
them.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Motor not operating</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the electricity in the Input section. If there is power, check the motor.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">PLC program inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. OPEN MAIN TECHNIQUES to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Mechanical components are not operational</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the sprockets, chains or bearings. Repair or replace if it is no longer suitable. </span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Wiring errors, loose connections, or corroded connections.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the sequence of cables and connections. Repair or replace if necessary.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.8 TROUBLE 3.1' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 3.1</h5>
<p class="text-xs mt-1">Cabin no can rotate to the left, even though the other systems are functioning properly.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control circuit inoperative</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the sequence and contact connections of the Cabin Rotation button to the left so that it can
be used on the PLC. Repair or replace if necessary.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the Limit Switch for Cabin Rotation for the left LS17A. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check Limit Switch for Cabin Rotation LS18A (back up).</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check the contacts/connections and magnetic coil of contactor C6 for Cabin Rotation in the left
direction. Repair or replace if necessary.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Wiring errors, loose connections, or corroded connections.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the sequence of cables and connections. Repair or replace if necessary.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">PLC program inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. OPEN MAIN TECHNIQUES to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.9 TROUBLE 3.2' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 3.2</h5>
<p class="text-xs mt-1">Cabin no can rotate to the right, even though the other systems are functioning properly.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control Circuitry is not operational.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the sequence and contact connections of the Cabin Rotation button to the right so that it can
be used on the PLC. Repair or replace if necessary.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the Limit Switch for Cabin Rotation for the right LS17B. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check Ultimate Limit Switch for Cabin Rotation LS18B (back up).</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check the contacts/connections and magnetic coil of contactor C7 for Cabin Rotation in the right
direction. Repair or replace if necessary.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check the input and output terminal links. If it doesn\'t work, replace.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Wiring errors, loose connections, or corroded connections.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the sequence of cables and connections. Repair or replace if necessary.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">PLC program inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. OPEN MAIN TECHNIQUES to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.10 TROUBLE 4' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 4</h5>
<p class="text-xs mt-1">Auto level Arm not can move when the keyswitch button is positioned in AUTOLEVEL mode, while the
indicator light is on.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control Circuitry is not operational.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the position of the keyswitch. If it doesn\'t work, repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check RL13. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check the wiring for the PLC. If there are loose/loose connections, repair them.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Interlock System for vertical movement is not active.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check the AUTOLEVEL light. If it doesn\'t work, replace it.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">PLC program inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. OPEN MAIN TECHNIQUES to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Motor Actuator of Autolevel does not operate</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the Motor Actuator. If it doesn\'t work, repair or replace the motor.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">The mechanism in the Arm is jammed, broken or missing parts</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Remove obstructions and repair.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.11 TROUBLE 5' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 5</h5>
<p class="text-xs mt-1">Alarm sound not working during AUTOLEVEL mode and when Automatic Leveling does not function or when
the Garbarata Main Power is down.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control circuit not operating</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check relay RL14. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check keyswitch. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check the Dry Battery and voltage (24VDC). If it doesn\'t work, repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check the alarm sounder. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check the wiring for the PLC. If a connection is damaged, repair it.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">PLC program inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. OPEN MAIN TECHNIQUES to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Horn not working</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the alarm tool. If it doesn\'t work, replace it.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.12 TROUBLE 6' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 6</h5>
<p class="text-xs mt-1">When control is in position AUTO mode, Auto Level Arm and Wheels stop on the fuselage of the
aircraft and the Garbarata electricity supply is \'ON\', the Garbarata does not follow the up/down
movement of the plane.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control Circuitry is not operational.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check keyswitch. If it doesn\'t work, repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check Limit Switches LS26A and LS26B. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">If any cables are not connected, repair them.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check the wiring for the PLC. If a connection is damaged, repair it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Interlock Active, check the vertical limit indicator, Slope Limit, and Column Fault Limit Switch.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">PLC program inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. OPEN MAIN TECHNIQUES to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.13 TROUBLE 7' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 7</h5>
<p class="text-xs mt-1">When control is on AUTO mode, the Autolevel indicator is ON, the Service Warning is on and flashing
while the Buzzer / buzzing sound is heard continuously.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control circuit not operational</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the Autolevel Fuse, if the fuse is broken, replace it with a new fuse.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Wiring errors, loose connections, or corroded connections.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the sequence of cables and connections. Repair or replace if necessary.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">PLC program inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. BTU to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.14 TROUBLE 8' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 8</h5>
<p class="text-xs mt-1">Horizontal Motor does not react to all commands.</p>
</div>
<div class="bg-blue-50 text-blue-900 p-3 rounded-lg border border-blue-100 text-xs mb-4">
<strong>NOTE : When this happens, make sure that:</strong>
<ul class="list-decimal pl-4 mt-1.5 space-y-1">
<li>The power light is on. If there is power.</li>
<li>The Keyswitch button is in the Manual position.</li>
<li>Make sure that the Canopy is fully Retracted, and the Canopy Down indicator is Off.</li>
<li>The position of the Garbarata is within the lengthening or shortening limit and within the rotation
limit, where the limit switches do not move.</li>
<li>MCCB3 on the Distribution Power Panel is ON.</li>
</ul>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control Circuitry is not operational.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the three-position switch. If it doesn\'t work, repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the micro switch and potentiometer on the Joystick. If it doesn\'t work, repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check Steering PCB. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check Limit Switches LS1A, LS1B, LS2A, LS2B, LS3A, LS3B, LS4A, LSB, LS19, LS23, LS24, LS25, LS21 and
PX1. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check Limit Switches for Wheel Boogie LS13, LS14, LS15 or LS16. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">6</span>
<span class="flex-1">Check all controller cable systems. If damaged, replace.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">7</span>
<span class="flex-1">Check the Input and Output terminal connections. If it doesn\'t work, replace it.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">MCCB3 to power...</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Turn/\'ON\' MCCB3. If the MCCB3 Tripped again, check for cable network errors or other causes that
caused the Trip.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Brakes on Horizontal Motor work abnormally</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check magnetic connector C3, coils and connections. Replace if necessary.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the brake components on the Horizontal Motor Drive. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">See Operation Manual for Brake Motors.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Inverter transistor not working</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check and measure the Input Power Voltage/voltage entering R1/S1/T1.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the circuit for faults, loose connections or corroded connections.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">If the Inverter Transistor is not working, replace it.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Mechanical part not working</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the sprockets, chains and bearings. Replace if it doesn\'t work.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">6</span>
<span class="flex-1">Wiring errors, loose connections, or corroded connections.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the sequence of cables and connections. Repair or replace if necessary.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.15 TROUBLE 9' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 9</h5>
<p class="text-xs mt-1">Wheel Boogie still turn right or left even if the Joystick is pointing straight forward or backward.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Inverter transistor not working</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the right or left Inverter Transistor.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">If the Boogie Wheel turns to the right, check the right Inverter. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">If the Boogie Wheel rotates to the left, check the left Inverter. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check Steering PCB. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check the cables. If damaged, replace.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">The positive and negative poles of the voltage are not correct</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the cables on the right and left of the Horizontal Motor. If it\'s not correct, correct it.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Brake on Horizontal Drive Motor not working</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the connections and magnetic coils of contactor C3. Repair as necessary, or if not working,
replace.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Brakes are not working. If Input Power is normal, repair or replace the brake.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">See Operational Manual for Brake Motors.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">The program that has been set for the Inverter Transistor is incorrect</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Reload parameter program for Horizontal Drive Inverter.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">See Instruction Manual for Transistor Inverter.</span>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.16 TROUBLE 10' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 10</h5>
<p class="text-xs mt-1">Drive Unit/ unit the drive moves to and fro when moving straight forward or backward.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Cable network errors, loose connections, or corroded connections.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check connection. Repair or replace if necessary.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Limit Switch slow down LS5 cannot operate.</span>
</div>
</td>>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the arm lever limit switch, if it touches the tunnel, release it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check the cable completely if anything is damaged, replace it immediately.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Scanner (Photo electric) for slow down cannot operate</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the scanner (photo electric) left or right, if it malfunctions, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the glass on the scanner, if it is dirty, clean it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check the power entering the scanner, if any means the scanner is damaged, it must be replaced.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check the cable as a whole, if there is damage it means it must be replaced.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check and move if anything is blocking the scanner.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Inverter transistor cannot operate</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the inverter program.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">See the instruction manual for the inverter transistor.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Control circuit inoperable</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the potentiometer on the joystick, if it malfunctions, repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the wiring system for the PLC, if it malfunctions, repair it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check potentio adjustment for PCB Steering.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check the input and output terminal links, if they malfunction, replace them.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">6</span>
<span class="flex-1">There is some resistance on the roller track</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the roller track as a whole, top, bottom, front and back.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Remove objects or objects that are in the path of the roller.</span>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.17 TROUBLE 11' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 11</h5>
<p class="text-xs mt-1">Power available and the horizontal motor drive hums, but does not operate.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Brake does not open.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check connection C3, if damaged, replace.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">The brakes are malfunctioning. If the input is normal, repair or replace the brake.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Wiring damage or loss of connection</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Next check the wiring circuit and connections. Repair or replace if necessary.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Horizontal motor cable is damaged.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the horizontal motor cable, if not connected, replace.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Motor cannot operate.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the motor with a megger tester (merger tester), if it malfunctions, replace it.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Mechanical problems</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the motorbike as a whole and its components, such as brakes, chains, etc.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.18 TROUBLE 12' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 12</h5>
<p class="text-xs mt-1">Canopy Closure won\'t go up or down</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control Circuit inoperative</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check whether the Service Warning indicator is on. Check MCB4 and MCB5. If damaged, replace.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the Keyswitch, if it doesn\'t work repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check the Canopy Up/Down buttons. If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Check the Limit Switches for the left canopy LS19, LS20A, and LS20B. If it doesn\'t work, replace
it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Check the Limit Switches for the right canopy LS21, LS22A, and LS22B. If it doesn\'t work, replace
it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">6</span>
<span class="flex-1">Check RL11 and RL12 for the right canopy Motor Actuator. Be careful the voltage is 220VAC {1 phase}.
If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">7</span>
<span class="flex-1">Check RL9 and RL10 for the left canopy Motor Actuator. Be careful the voltage is 220VAC {1 phase}.
If it doesn\'t work, replace it.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">8</span>
<span class="flex-1">A cable may be broken, replace the cable.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">9</span>
<span class="flex-1">Check for cable network errors, loose connections or corroded connections.</span>
</div>
<div class="flex items-start">
<span class="w-5 shrink-0 font-semibold text-slate-700">10</span>
<span class="flex-1">Check the connection of the Input and Output terminals. If it doesn\'t work, replace it.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Canopy right/left motor actuator does not operate</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the incoming power/electricity. If there is incoming voltage, repair or replace the motor.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the brakes for the Motor Actuator. If it doesn\'t work, replace it.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">PLC program inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. OPEN MAIN TECHNIQUES to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Faults in the cable network, loose connections or rust on the connections</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Continue checking the cables and connections. Repair or replace if necessary.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Mechanical Problems</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check and remove obstructions to the canopy mechanical system.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.19 TROUBLE 13' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 13</h5>
<p class="text-xs mt-1">Motor Canopy actuator sounds or motor is damaged.</p>
</div>
<div class="bg-blue-50 text-blue-900 p-3 rounded-lg border border-blue-100 text-xs mb-4">
<strong>NOTE :</strong> Make sure the motor is not stuck when the Arm Canopy is running.</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Control Circuitry is not operational.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">See Problem 12. Follow action no. 1 to 10.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Motor Capacitor not operating</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the Canopy Motor Capacitor inside the Console Desk. Check the voltage in the motor. If it is
normal and the motor does not run, the Capacitor is not working, replace it.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Canopy Motor not operating</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the Actuator Motor brake. If it doesn\'t work, replace or repair it.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.20 TROUBLE 14' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 14</h5>
<p class="text-xs mt-1">Lights</p>
<ul class="list-disc pl-4 text-xs mt-1.5 space-y-1 text-red-700">
<li>Check all lamp cables.</li>
<li>Make sure that MCB1 as the source of electrical power for the lights is ON and electricity is
available.</li>
<li>Make sure that the light switch is functioning normally.</li>
</ul>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Lights are not on</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">The lamp is damaged, replace the lamp.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Wrong cabling, fix.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">adapter not working, replace lamp.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">Humidity is too high.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">Lamp temperature that is too low or high.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Short lamp life span</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Incorrect voltage.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Cable installation error.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Short lamp life time (less than the average daily lamp usage). Check with the lamp manufacturer.</span>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>',
            '4.7.21 TROUBLE 15' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">
<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">
<h5 class="font-bold text-xs uppercase">TROUBLE 15</h5>
<p class="text-xs mt-1">Indicator of The Vertical Lift Column lights up and an error message appears.</p>
</div>
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">
<thead>
<tr class="bg-gray-50 text-slate-700 font-bold">
<th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th>
<th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-100 text-slate-600">
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">One side of the Vertical Lift Column moves faster than the other causing the side to tilt.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<div class="flex-1">
<span>The Column Fault indicator will light up if one of the Columns/poles rises 70mm higher than the
other. This can cause structural damage to the Lift Column. If this happens then check:</span>
<div class="pl-4 mt-1.5 space-y-1">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">a</span>
<div class="flex-1">
<span>Base plate of the Lift Column.</span>
<div class="pl-4 mt-0.5 space-y-0.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">i</span>
<span class="flex-1">Check for loose or loose bolts.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">ii</span>
<span class="flex-1">Check for damaged/cracked welds/metal joints.</span>
</div>
</div>
</div>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">c</span>
<span class="flex-1">Column Elevator Box. Check the inside of the box, make sure nothing is damaged, repair the dominant
damage so that the bridge can operate again.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">d</span>
<span class="flex-1">If both Lift Columns are not aligned and the vertical Lift Column error indicator lights up, the
maintenance department should be contacted immediately.</span>
</div>
</div>
<div class="mt-2 p-2 bg-amber-50 text-amber-900 border border-amber-100 rounded">
<strong>WARNING:</strong>
<ul class="list-disc pl-4 mt-1 space-y-1 text-slate-700">
<li>Operators are not advised to repair damage.</li>
<li>Contact PT. OPEN THE MAIN TECH if there is serious damage to the Garbarata structure.</li>
</ul>
</div>
</div>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">The Control Circuit is inoperable.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check Limit Switch Column Fault, L and R (LS7 & LS8).</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check all cables. If damaged, replace.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">Check the connection of the Input and Output terminals. If it doesn\'t work, replace it.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">The right and left vertical motors are not operational.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check vertical motor. If damaged, replace.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">4</span>
<span class="flex-1">One ​​of the motor\'s vertical mechanical brakes is inoperative.</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="space-y-1.5">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the mechanical brakes. If it doesn\'t work, repair or replace it.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">2</span>
<span class="flex-1">Check the brake motor magnetic coils/coils {C4 and CS}. If damaged, replace.</span>
</div>
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">3</span>
<span class="flex-1">See instruction manual for brake motor.</span>
</div>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">5</span>
<span class="flex-1">One ​​of the Ball Screws is not working</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Check the tolerance of the installed screws. If it doesn\'t work, fix it if possible.</span>
</div>
</td>
</tr>
<tr>
<td class="p-2 border border-gray-200 align-top">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">6</span>
<span class="flex-1">Program inoperative or missing</span>
</div>
</td>
<td class="p-2 border border-gray-200">
<div class="flex items-start">
<span class="w-4 shrink-0 font-semibold text-slate-700">1</span>
<span class="flex-1">Contact PT. BTU to send a new program to replace the existing one.</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-4 p-3 bg-blue-50 text-blue-900 border border-blue-100 rounded-lg text-xs">
<strong>NOTE:</strong>When the Column Lift does not work, the maintenance department must find the cause. Once the cause
has been found, fix it. If no damage is found to the structure, the procedures in section 3.5
(Setting Procedures for Lift Columns), this chapter must be followed so that the Lift Column returns
to the correct position.</div>
</div>
</div>',
            '5.1.1 Rotunda Assembly' => '<h4 class="font-bold text-slate-800 text-xs mb-2">5.1.1. Rotunda Assembly</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
the Rotunda Assembly.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1085/1450] max-w-sm select-none">
<img src="/images/modules/technical_drawing.png" class="w-full h-full object-cover rounded-lg" alt="Rotunda Technical Drawing">
<!-- Hotspots -->
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 29.31%; top: 45.93%;" onclick="scrollToPartRow(1)" title="1. Barrel Rotunda Curtain Assembly (Left side)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 38.34%; top: 56.00%;" onclick="scrollToPartRow(3)" title="3. Guide Pipe Barrel">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 45.71%; top: 66.48%;" onclick="scrollToPartRow(3)" title="3. Guide Pipe Barrel">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 48.66%; top: 50.62%;" onclick="scrollToPartRow(4)" title="4. Tension Barrel Bearing">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 5.53%; top: 69.38%;" onclick="scrollToPartRow(5)" title="5. Slat Curtain Assy (L/R)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 22.67%; top: 57.52%;" onclick="scrollToPartRow(6)" title="6. Tension Barrel">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 53.27%; top: 56.00%;" onclick="scrollToPartRow(7)" title="7. Guide Pipe Barrel Bearing">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 73.92%; top: 6.21%;" onclick="scrollToPartRow(8)" title="8. Roller Bearing Rotunda">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 59.72%; top: 5.52%;" onclick="scrollToPartRow(9)" title="9. Plate Curtain Upper">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 13.27%; top: 46.76%;" onclick="scrollToPartRow(9)" title="9. Plate Curtain Upper">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 19.72%; top: 28.55%;" onclick="scrollToPartRow(10)" title="10. Potentiometer Rotunda Assy">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 88.66%; top: 30.62%;" onclick="scrollToPartRow(11)" title="11. Hinge Pin">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 45.71%; top: 55.59%;" onclick="scrollToPartRow(12)" title="12. Plate Seat Curtain (L/R)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 18.99%; top: 45.66%;" onclick="scrollToPartRow(13)" title="13. Worm Gear Assembly (L/R)">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="part-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">ORT001AM</td>
<td class="p-2.5">Barrel Rotunda Curtain Assembly (Left side)</td>
</tr>
<tr id="part-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">ORT002AM</td>
<td class="p-2.5">Barrel Rotunda Curtain Assembly (Right side)</td>
</tr>
<tr id="part-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">ORT103AM</td>
<td class="p-2.5">Guide Pipe Barrel</td>
</tr>
<tr id="part-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">ORT004SM</td>
<td class="p-2.5">Tension Barrel Bearing</td>
</tr>
<tr id="part-row-5" class="transition duration-300">
<td class="p-2.5 text-center font-bold">5</td>
<td class="p-2.5 font-mono">ORT005AM</td>
<td class="p-2.5">Slat Curtain Assy (L/R)</td>
</tr>
<tr id="part-row-6" class="transition duration-300">
<td class="p-2.5 text-center font-bold">6</td>
<td class="p-2.5 font-mono">ORT104AM</td>
<td class="p-2.5">Tension Barrel</td>
</tr>
<tr id="part-row-7" class="transition duration-300">
<td class="p-2.5 text-center font-bold">7</td>
<td class="p-2.5 font-mono">ORT105AM</td>
<td class="p-2.5">Guide Pipe Barrel Bearing</td>
</tr>
<tr id="part-row-8" class="transition duration-300">
<td class="p-2.5 text-center font-bold">8</td>
<td class="p-2.5 font-mono">ORT008AM</td>
<td class="p-2.5">Roller Bearing Rotunda</td>
</tr>
<tr id="part-row-9" class="transition duration-300">
<td class="p-2.5 text-center font-bold">9</td>
<td class="p-2.5 font-mono">ORT106AM</td>
<td class="p-2.5">Plate Curtain Upper</td>
</tr>
<tr id="part-row-10" class="transition duration-300">
<td class="p-2.5 text-center font-bold">10</td>
<td class="p-2.5 font-mono">ORT023SM</td>
<td class="p-2.5">Potentiometer Rotunda Assy</td>
</tr>
<tr id="part-row-11" class="transition duration-300">
<td class="p-2.5 text-center font-bold">11</td>
<td class="p-2.5 font-mono">ORT012CM</td>
<td class="p-2.5">Hinge Pin</td>
</tr>
<tr id="part-row-12" class="transition duration-300">
<td class="p-2.5 text-center font-bold">12</td>
<td class="p-2.5 font-mono">ORT013CM</td>
<td class="p-2.5">Plate Seat Curtain (L/R)</td>
</tr>
<tr id="part-row-13" class="transition duration-300">
<td class="p-2.5 text-center font-bold">13</td>
<td class="p-2.5 font-mono">ORT013AM</td>
<td class="p-2.5">Worm Gear Assembly (L/R)</td>
</tr>
<tr id="part-row-14" class="transition duration-300">
<td class="p-2.5 text-center font-bold">14</td>
<td class="p-2.5 font-mono">ORT107AM</td>
<td class="p-2.5">Carpet for Rotunda</td>
</tr>
</tbody>
</table>
</div>
<script>function scrollToPartRow(no) { const row = document.getElementById("part-row-" + no); if (row) {
row.scrollIntoView({ behavior: "smooth", block: "center" });
document.querySelectorAll(\'[id^="part-row-"]\').forEach(r => { r.classList.remove("bg-blue-50",
"text-blue-900", "font-semibold"); }); row.classList.add("bg-blue-50", "text-blue-900",
"font-semibold"); setTimeout(() => { row.classList.remove("bg-blue-50", "text-blue-900",
"font-semibold"); }, 2000); }}</script>',
            '5.1.2 Tunnel Roller' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.2. Tunnel Roller</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) of the roller installation location and
component assembly details for the Tunnel Roller.<strong>Click on the transparent blue circle button in the location map image</strong>to view the assembly details on the appropriate reference sheet, as well as highlight the part
number in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1181/1332] max-w-sm select-none">
<img src="/images/modules/TunnelRoller/tunnel_roller.png" class="w-full h-full object-cover rounded-lg" alt="Tunnel Roller Location Map">
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 42.85%; top: 15.62%;" onclick="scrollToRollerRow(1)" title="1. Fixed Roller (B2 Tunnel A Upper Rear)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 63.51%; top: 34.23%;" onclick="scrollToRollerRow(2)" title="2. Side Roller (B2 Tunnel A Lower Outer Front)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 55.38%; top: 37.99%;" onclick="scrollToRollerRow(3)" title="3. Tandem Roller (B2 Tunnel A Lower Front)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 71.46%; top: 29.13%;" onclick="scrollToRollerRow(4)" title="4. Nosing Ramp">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 52.50%; top: 12.76%;" onclick="scrollToRollerRow(5)" title="5. Fixed Roller (B2 Tunnel A Upper Front)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 41.49%; top: 43.09%;" onclick="scrollToRollerRow(6)" title="6. Fixed Roller (B2 Tunnel A Lower Rear)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 30.14%; top: 62.91%;" onclick="scrollToRollerRow(7)" title="7. Fixed Roller (B3 Tunnel A Upper Rear)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 36.75%; top: 59.46%;" onclick="scrollToRollerRow(8)" title="8. Fixed Roller (B3 Tunnel A Upper Front)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 34.21%; top: 87.84%;" onclick="scrollToRollerRow(9)" title="9. Fixed Roller (B3 Tunnel A Lower Rear)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 54.36%; top: 50.60%;" onclick="scrollToRollerRow(10)" title="10. Fixed Roller (B3 Tunnel B Upper Rear)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.29%; top: 46.55%;" onclick="scrollToRollerRow(11)" title="11. Fixed Roller (B3 Tunnel B Upper Front)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.41%; top: 77.03%;" onclick="scrollToRollerRow(12)" title="12. Fixed Roller (B3 Tunnel B Lower Rear)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 44.88%; top: 86.04%;" onclick="scrollToRollerRow(13)" title="13. Side Roller (B3 Tunnel A Lower Middle)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 74.68%; top: 67.87%;" onclick="scrollToRollerRow(14)" title="14. Side Roller (B3 Tunnel B Lower Outer Front)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 50.80%; top: 81.83%;" onclick="scrollToRollerRow(15)" title="15. Tandem Roller (B3 Tunnel A Lower Front)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 69.43%; top: 75.08%;" onclick="scrollToRollerRow(16)" title="16. Tandem Roller (B3 Tunnel B Lower Front)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.97%; top: 81.68%;" onclick="scrollToRollerRow(17)" title="17. Nosing Ramp">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 81.29%; top: 65.62%;" onclick="scrollToRollerRow(18)" title="18. Nosing Ramp">
</button>
</div>
<div x-data="{ activeTab: 1 }" @switch-detail-tab.window="activeTab = $event.detail.tab" class="my-6 border border-slate-200 rounded-xl bg-slate-50/50 p-4 shadow-sm">
<!-- Tab Headers -->
<div class="flex flex-wrap gap-2 border-b border-slate-200 pb-3 mb-4 text-[10px] font-bold text-slate-500">
<button type="button" @click="activeTab = 1" :class="activeTab === 1 ? \'bg-blue-600 text-white shadow-xs\' : \'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200\'" class="px-3 py-1.5 rounded-lg transition focus:outline-none"> Detail B2 (Roller 1-6) </button>
<button type="button" @click="activeTab = 2" :class="activeTab === 2 ? \'bg-blue-600 text-white shadow-xs\' : \'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200\'" class="px-3 py-1.5 rounded-lg transition focus:outline-none"> Detail B3 - Part 1 (Roller 7-12) </button>
<button type="button" @click="activeTab = 3" :class="activeTab === 3 ? \'bg-blue-600 text-white shadow-xs\' : \'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200\'" class="px-3 py-1.5 rounded-lg transition focus:outline-none"> Detail B3 - Part 2 (Roller 13-16) </button>
</div>
<!-- Tab Contents -->
<!-- Tab 1: reference_B2.png (B2 - Roller 1 to 6) -->
<div x-show="activeTab === 1" x-transition.opacity class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm aspect-[1073/1466] max-w-xs select-none">
<img src="/images/modules/TunnelRoller/reference_B2.png" class="w-full h-full object-cover rounded-lg" alt="Reference B2 Rollers">
<button type="button" id="roller-hotspot-1" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 9.32%; top: 37.93%;" onclick="scrollToRollerRow(1)" title="1. Fixed Roller (B2 Upper Rear)">
</button>
<button type="button" id="roller-hotspot-2" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.60%; top: 33.83%;" onclick="scrollToRollerRow(2)" title="2. Side Roller (B2 Lower Outer Front)">
</button>
<button type="button" id="roller-hotspot-3" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 9.32%; top: 70.94%;" onclick="scrollToRollerRow(3)" title="3. Tandem Roller (B2 Lower Front)">
</button>
<button type="button" id="roller-hotspot-5" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.76%; top: 70.80%;" onclick="scrollToRollerRow(5)" title="5. Fixed Roller (B2 Upper Front)">
</button>
<button type="button" id="roller-hotspot-6" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 34.30%; top: 90.59%;" onclick="scrollToRollerRow(6)" title="6. Fixed Roller (B2 Lower Rear)">
</button>
</div>
<!-- Tab 2: reference_B3.png (B3 - Roller 7 to 12) -->
<div x-show="activeTab === 2" x-transition.opacity class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm aspect-[1037/1517] max-w-xs select-none">
<img src="/images/modules/TunnelRoller/reference_B3.png" class="w-full h-full object-cover rounded-lg" alt="Reference B3 Rollers Part 1">
<button type="button" id="roller-hotspot-7" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 6.17%; top: 33.49%;" onclick="scrollToRollerRow(7)" title="7. Fixed Roller (B3 Upper Rear)">
</button>
<button type="button" id="roller-hotspot-8" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.95%; top: 43.51%;" onclick="scrollToRollerRow(8)" title="8. Fixed Roller (B3 Upper Front)">
</button>
<button type="button" id="roller-hotspot-9" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 9.45%; top: 66.58%;" onclick="scrollToRollerRow(9)" title="9. Fixed Roller (B3 Lower Rear)">
</button>
<button type="button" id="roller-hotspot-10" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 62.87%; top: 67.50%;" onclick="scrollToRollerRow(10)" title="10. Fixed Roller (B3 Upper Rear)">
</button>
<button type="button" id="roller-hotspot-11" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 7.91%; top: 97.17%;" onclick="scrollToRollerRow(11)" title="11. Fixed Roller (B3 Upper Front)">
</button>
<button type="button" id="roller-hotspot-12" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 63.84%; top: 96.64%;" onclick="scrollToRollerRow(12)" title="12. Fixed Roller (B3 Lower Rear)">
</button>
</div>
<!-- Tab 3: reference_B3(2).png (B3 - Roller 13 to 16) -->
<div x-show="activeTab === 3" x-transition.opacity class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm aspect-[1397/1126] max-w-sm select-none">
<img src="/images/modules/TunnelRoller/reference_B3(2).png" class="w-full h-full object-cover rounded-lg" alt="Reference B3 Rollers Part 2">
<button type="button" id="roller-hotspot-13" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 6.44%; top: 44.58%;" onclick="scrollToRollerRow(13)" title="13. Side Roller (B3 Lower Middle)">
</button>
<button type="button" id="roller-hotspot-14" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.98%; top: 45.12%;" onclick="scrollToRollerRow(14)" title="14. Side Roller (B3 Lower Outer Front)">
</button>
<button type="button" id="roller-hotspot-15" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 6.30%; top: 91.83%;" onclick="scrollToRollerRow(15)" title="15. Tandem Roller (B3 Lower Front)">
</button>
<button type="button" id="roller-hotspot-16" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.70%; top: 92.01%;" onclick="scrollToRollerRow(16)" title="16. Tandem Roller (B3 Lower Front)">
</button>
</div>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="roller-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">1AT001AM</td>
<td class="p-2.5">Fixed Roller Unit Assembly (B2 - Tunnel A - Upper Rear)</td>
</tr>
<tr id="roller-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">1AT005AM</td>
<td class="p-2.5">Side Roller Unit Assembly (B2 - Tunnel A - Lower Outer Front)</td>
</tr>
<tr id="roller-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">1AT006AM</td>
<td class="p-2.5">Tandem Roller Unit Assy. (B2 - Tunnel A - Lower Front)</td>
</tr>
<tr id="roller-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">1AT011CM</td>
<td class="p-2.5">Nosing Ramp</td>
</tr>
<tr id="roller-row-5" class="transition duration-300">
<td class="p-2.5 text-center font-bold">5</td>
<td class="p-2.5 font-mono">1AT023AM</td>
<td class="p-2.5">Fixed Roller Unit Assembly (B2 - Tunnel A - Upper Front)</td>
</tr>
<tr id="roller-row-6" class="transition duration-300">
<td class="p-2.5 text-center font-bold">6</td>
<td class="p-2.5 font-mono">1AT024AM</td>
<td class="p-2.5">Fixed Roller Unit Assembly (B2 - Tunnel A - Lower Rear)</td>
</tr>
<tr id="roller-row-7" class="transition duration-300">
<td class="p-2.5 text-center font-bold">7</td>
<td class="p-2.5 font-mono">2AT025AM</td>
<td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel A - Upper Rear)</td>
</tr>
<tr id="roller-row-8" class="transition duration-300">
<td class="p-2.5 text-center font-bold">8</td>
<td class="p-2.5 font-mono">2AT026AM</td>
<td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel A - Upper Front)</td>
</tr>
<tr id="roller-row-9" class="transition duration-300">
<td class="p-2.5 text-center font-bold">9</td>
<td class="p-2.5 font-mono">2AT027AM</td>
<td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel A - Lower Rear)</td>
</tr>
<tr id="roller-row-10" class="transition duration-300">
<td class="p-2.5 text-center font-bold">10</td>
<td class="p-2.5 font-mono">2BT017AM</td>
<td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel B - Upper Rear)</td>
</tr>
<tr id="roller-row-11" class="transition duration-300">
<td class="p-2.5 text-center font-bold">11</td>
<td class="p-2.5 font-mono">2BT018AM</td>
<td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel B - Upper Front)</td>
</tr>
<tr id="roller-row-12" class="transition duration-300">
<td class="p-2.5 text-center font-bold">12</td>
<td class="p-2.5 font-mono">2BT019AM</td>
<td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel B - Lower Rear)</td>
</tr>
<tr id="roller-row-13" class="transition duration-300">
<td class="p-2.5 text-center font-bold">13</td>
<td class="p-2.5 font-mono">2AT029AM</td>
<td class="p-2.5">Side Roller Unit Assembly (B3 - Tunnel A - Lower Middle)</td>
</tr>
<tr id="roller-row-14" class="transition duration-300">
<td class="p-2.5 text-center font-bold">14</td>
<td class="p-2.5 font-mono">2BT021AM</td>
<td class="p-2.5">Side Roller Unit Assembly (B3 - Tunnel B - Lower Outer Front)</td>
</tr>
<tr id="roller-row-15" class="transition duration-300">
<td class="p-2.5 text-center font-bold">15</td>
<td class="p-2.5 font-mono">2AT030AM</td>
<td class="p-2.5">Tandem Roller Unit Assy. (B3 - Tunnel A - Lower Front)</td>
</tr>
<tr id="roller-row-16" class="transition duration-300">
<td class="p-2.5 text-center font-bold">16</td>
<td class="p-2.5 font-mono">2BT022AM</td>
<td class="p-2.5">Tandem Roller Unit Assy. (B3 - Tunnel B - Lower Front)</td>
</tr>
<tr id="roller-row-17" class="transition duration-300">
<td class="p-2.5 text-center font-bold">17</td>
<td class="p-2.5 font-mono">2AT031CM</td>
<td class="p-2.5">Nosing Ramp</td>
</tr>
<tr id="roller-row-18" class="transition duration-300">
<td class="p-2.5 text-center font-bold">18</td>
<td class="p-2.5 font-mono">2BT023CM</td>
<td class="p-2.5">Nosing Ramp</td>
</tr>
<tr id="roller-row-19" class="transition duration-300">
<td class="p-2.5 text-center font-bold">19</td>
<td class="p-2.5 font-mono">2BT100CM</td>
<td class="p-2.5">Wall Glass</td>
</tr>
<tr id="roller-row-20" class="transition duration-300">
<td class="p-2.5 text-center font-bold">20</td>
<td class="p-2.5 font-mono">2BT101CM</td>
<td class="p-2.5">Handrail</td>
</tr>
<tr id="roller-row-21" class="transition duration-300">
<td class="p-2.5 text-center font-bold">21</td>
<td class="p-2.5 font-mono">2BT102CM</td>
<td class="p-2.5">Tunnel Carpet</td>
</tr>
</tbody>
</table>
</div>',
            '5.1.3 Cable carriage device' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.3. Cable carriage device</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
the Cable carriage device.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1068/1473] max-w-sm select-none">
<img src="/images/modules/5.1.3.cable.png" class="w-full h-full object-cover rounded-lg" alt="Cable Carriage Device Technical Drawing">
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 61.05%; top: 59.88%;" onclick="scrollToCableRow(1)" title="1. Scissor Cable Assembly">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="cable-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">OCS100CM</td>
<td class="p-2.5">Scissor Cable Assembly</td>
</tr>
</tbody>
</table>
</div>',
            '5.1.4 Vertical lift column' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.4. Vertical lift column</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
the Vertical lift column.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1440/2560] max-w-[280px] select-none">
<img src="/images/modules/5.1.4Vertical_lift_column.png" class="w-full h-full object-cover rounded-lg" alt="Vertical Lift Column Technical Drawing">
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 90.97%; top: 52.50%;" onclick="scrollToLiftRow(1)" title="1. Vertical Lift Column Assembly">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.47%; top: 5.39%;" onclick="scrollToLiftRow(2)" title="2. Motor Cover">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 71.39%; top: 22.50%;" onclick="scrollToLiftRow(3)" title="3. Horizontal Motor + Horizontal Motor Bracket + Chain Sprocket">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.33%; top: 93.98%;" onclick="scrollToLiftRow(4)" title="4. Pad Teflon Bearing Comp.">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 13.47%; top: 28.98%;" onclick="scrollToLiftRow(5)" title="5. Side Cover">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 59.72%; top: 26.09%;" onclick="scrollToLiftRow(6)" title="6. Proximity Switch">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.47%; top: 36.02%;" onclick="scrollToLiftRow(7)" title="7. Coupling system assy">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.47%; top: 39.77%;" onclick="scrollToLiftRow(8)" title="8. Upper Column Flange">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.33%; top: 51.25%;" onclick="scrollToLiftRow(9)" title="9. Bearing Thrust Assy /w Cup washer">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.47%; top: 65.08%;" onclick="scrollToLiftRow(10)" title="10. Ball Screw and Nut Assembly">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.47%; top: 81.95%;" onclick="scrollToLiftRow(11)" title="11. Nut Stopper">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="lift-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">OLC001AM</td>
<td class="p-2.5">Vertical Lift Column Assembly.</td>
</tr>
<tr id="lift-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">OLC013CM</td>
<td class="p-2.5">Motor Cover</td>
</tr>
<tr id="lift-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">OLC101AM</td>
<td class="p-2.5">Horizontal Motor + Horizontal Motor Bracket + Chain Sprocket</td>
</tr>
<tr id="lift-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">OLC007CM</td>
<td class="p-2.5">Teflon Pad Bearing Comp.</td>
</tr>
<tr id="lift-row-5" class="transition duration-300">
<td class="p-2.5 text-center font-bold">5</td>
<td class="p-2.5 font-mono">OLC048CM</td>
<td class="p-2.5">Side Cover</td>
</tr>
<tr id="lift-row-6" class="transition duration-300">
<td class="p-2.5 text-center font-bold">6</td>
<td class="p-2.5 font-mono">*</td>
<td class="p-2.5">Proximity Switch</td>
</tr>
<tr id="lift-row-7" class="transition duration-300">
<td class="p-2.5 text-center font-bold">7</td>
<td class="p-2.5 font-mono">OLC102AM</td>
<td class="p-2.5">Coupling system assy</td>
</tr>
<tr id="lift-row-8" class="transition duration-300">
<td class="p-2.5 text-center font-bold">8</td>
<td class="p-2.5 font-mono">OLC103AM</td>
<td class="p-2.5">Upper Column Flange</td>
</tr>
<tr id="lift-row-9" class="transition duration-300">
<td class="p-2.5 text-center font-bold">9</td>
<td class="p-2.5 font-mono">OLC104AM</td>
<td class="p-2.5">Bearing Thrust Assy /w Cup washer</td>
</tr>
<tr id="lift-row-10" class="transition duration-300">
<td class="p-2.5 text-center font-bold">10</td>
<td class="p-2.5 font-mono">OLC006AM</td>
<td class="p-2.5">Ball Screw and Nut Assembly.</td>
</tr>
<tr id="lift-row-11" class="transition duration-300">
<td class="p-2.5 text-center font-bold">11</td>
<td class="p-2.5 font-mono">OLC011CM</td>
<td class="p-2.5">Nut Stopper</td>
</tr>
</tbody>
</table>
</div>
<p class="text-[10px] text-slate-400 mt-1 italic">Note: * See part code in the list of electrical components.</p>',
            '5.1.5 Wheel Bogie Assembly' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.5. Wheel Bogie Assembly</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
the Wheel Bogie Assembly.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[864/1217] max-w-sm select-none">
<img src="/images/modules/5.1.5.Wheel_Bogie_Assembly.png" class="w-full h-full object-cover rounded-lg" alt="Wheel Bogie Assembly Technical Drawing">
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 31.25%; top: 86.28%;" onclick="scrollToBogieRow(1)" title="1. Potentiometer Assy /w Cover">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 15.74%; top: 71.98%;" onclick="scrollToBogieRow(2)" title="2. Boogie Frame">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 18.75%; top: 40.10%;" onclick="scrollToBogieRow(3)" title="3. Thrust Bearing /w Clamp">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 37.50%; top: 58.01%;" onclick="scrollToBogieRow(4)" title="4. Swiveling Column">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 15.74%; top: 34.02%;" onclick="scrollToBogieRow(5)" title="5. Tyre Complete">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 61.81%; top: 25.80%;" onclick="scrollToBogieRow(6)" title="6. Horizontal Motor">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 63.43%; top: 42.89%;" onclick="scrollToBogieRow(7)" title="7. Carriage Frame Shaft">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 61.57%; top: 48.48%;" onclick="scrollToBogieRow(8)" title="8. Carriage Frame">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 54.65%; top: 64.75%;" onclick="scrollToBogieRow(9)" title="9. Drive System (Chain and Sprocket)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 35.42%; top: 1.48%;" onclick="scrollToBogieRow(10)" title="10. Chain Cover">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 82.18%; top: 69.35%;" onclick="scrollToBogieRow(11)" title="11. Solid Tyre">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 86.81%; top: 73.62%;" onclick="scrollToBogieRow(12)" title="12. Wheel Rim">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 66.20%; top: 53.25%;" onclick="scrollToBogieRow(13)" title="13. Oil Seal">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 70.83%; top: 53.57%;" onclick="scrollToBogieRow(14)" title="14. Bushing Oil Seal">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 86.57%; top: 61.79%;" onclick="scrollToBogieRow(15)" title="15. Wheel Hub /w Roller Bearing">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 59.03%; top: 94.66%;" onclick="scrollToBogieRow(16)" title="16. Wheel Cover">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 62.96%; top: 97.95%;" onclick="scrollToBogieRow(17)" title="17. Hub Cap">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 52.78%; top: 89.73%;" onclick="scrollToBogieRow(18)" title="18. Landing Gear">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="bogie-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">OLC102AE</td>
<td class="p-2.5">Potentiometer Assy /w Cover</td>
</tr>
<tr id="bogie-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">OLC105AM</td>
<td class="p-2.5">Boogie Frame</td>
</tr>
<tr id="bogie-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">OLC106AM</td>
<td class="p-2.5">Thrust Bearing /w Clamp</td>
</tr>
<tr id="bogie-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">OLC107AM</td>
<td class="p-2.5">Swiveling Column</td>
</tr>
<tr id="bogie-row-5" class="transition duration-300">
<td class="p-2.5 text-center font-bold">5</td>
<td class="p-2.5 font-mono">OLC023CM</td>
<td class="p-2.5">Tyre Complete</td>
</tr>
<tr id="bogie-row-6" class="transition duration-300">
<td class="p-2.5 text-center font-bold">6</td>
<td class="p-2.5 font-mono">OLC108CM</td>
<td class="p-2.5">Horizontal Motor</td>
</tr>
<tr id="bogie-row-7" class="transition duration-300">
<td class="p-2.5 text-center font-bold">7</td>
<td class="p-2.5 font-mono">OLC025CM</td>
<td class="p-2.5">Carriage Frame Shaft</td>
</tr>
<tr id="bogie-row-8" class="transition duration-300">
<td class="p-2.5 text-center font-bold">8</td>
<td class="p-2.5 font-mono">OLC100AM</td>
<td class="p-2.5">Carriage Frame</td>
</tr>
<tr id="bogie-row-9" class="transition duration-300">
<td class="p-2.5 text-center font-bold">9</td>
<td class="p-2.5 font-mono">OLC109AM</td>
<td class="p-2.5">Drive System (Chain and Sprocket)</td>
</tr>
<tr id="bogie-row-10" class="transition duration-300">
<td class="p-2.5 text-center font-bold">10</td>
<td class="p-2.5 font-mono">OLC017CM</td>
<td class="p-2.5">Chain Cover</td>
</tr>
<tr id="bogie-row-11" class="transition duration-300">
<td class="p-2.5 text-center font-bold">11</td>
<td class="p-2.5 font-mono">OLC110SM</td>
<td class="p-2.5">Solid Tire</td>
</tr>
<tr id="bogie-row-12" class="transition duration-300">
<td class="p-2.5 text-center font-bold">12</td>
<td class="p-2.5 font-mono">OLC111AM</td>
<td class="p-2.5">Wheel Rim</td>
</tr>
<tr id="bogie-row-13" class="transition duration-300">
<td class="p-2.5 text-center font-bold">13</td>
<td class="p-2.5 font-mono">OLC019CM</td>
<td class="p-2.5">Oil Seal</td>
</tr>
<tr id="bogie-row-14" class="transition duration-300">
<td class="p-2.5 text-center font-bold">14</td>
<td class="p-2.5 font-mono">OLC032CM</td>
<td class="p-2.5">Bushing Oil Seal</td>
</tr>
<tr id="bogie-row-15" class="transition duration-300">
<td class="p-2.5 text-center font-bold">15</td>
<td class="p-2.5 font-mono">OLC112AM</td>
<td class="p-2.5">Wheel Hub /w Roller Bearing</td>
</tr>
<tr id="bogie-row-16" class="transition duration-300">
<td class="p-2.5 text-center font-bold">16</td>
<td class="p-2.5 font-mono">OLC026CM</td>
<td class="p-2.5">Wheel Cover</td>
</tr>
<tr id="bogie-row-17" class="transition duration-300">
<td class="p-2.5 text-center font-bold">17</td>
<td class="p-2.5 font-mono">OLC024CM</td>
<td class="p-2.5">Hub Cap</td>
</tr>
<tr id="bogie-row-18" class="transition duration-300">
<td class="p-2.5 text-center font-bold">18</td>
<td class="p-2.5 font-mono">OLC052AM</td>
<td class="p-2.5">Landing Gear</td>
</tr>
<tr id="bogie-row-19" class="transition duration-300">
<td class="p-2.5 text-center font-bold">19</td>
<td class="p-2.5 font-mono">OLC113AM</td>
<td class="p-2.5">Safety Hoop</td>
</tr>
</tbody>
</table>
</div>
<p class="text-[10px] text-slate-400 mt-1 italic">Note: * Please see part code in the list of electrical components.</p>',
            '5.1.6 Landing Stair' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.6. Landing Stair</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
the Landing Stair.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1664/2536] max-w-sm select-none">
<img src="/images/modules/5.1.6.Landing_Stair.png" class="w-full h-full object-cover rounded-lg" alt="Landing Stair Technical Drawing">
<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 88.40%; top: 10.76%;" onclick="scrollToStairRow(1)" title="1. Door Closer">
</button>
<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 88.40%; top: 17.11%;" onclick="scrollToStairRow(2)" title="2. Service Door Assembly">
</button>
<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 47.00%; top: 3.51%;" onclick="scrollToStairRow(3)" title="3. Roof Ladder 1">
</button>
<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 88.40%; top: 28.12%;" onclick="scrollToStairRow(4)" title="4. Lock Unit & door handle">
</button>
<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 51.92%; top: 3.47%;" onclick="scrollToStairRow(5)" title="5. Roof Ladder 2">
</button>
<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 9.19%; top: 90.14%;" onclick="scrollToStairRow(6)" title="6. Castor Wheel">
</button>
<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 37.38%; top: 14.67%;" onclick="scrollToStairRow(7)" title="7. Hand Rail 2">
</button>
<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.57%; top: 7.26%;" onclick="scrollToStairRow(8)" title="8. Hand Rail 3">
</button>
<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 18.39%; top: 48.03%;" onclick="scrollToStairRow(9)" title="9. Hand Rail 1">
</button>
<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 26.38%; top: 43.85%;" onclick="scrollToStairRow(10)" title="10. Step Plate">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="stair-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">OBB001SM</td>
<td class="p-2.5">Door Closer</td>
</tr>
<tr id="stair-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">OBB002AM</td>
<td class="p-2.5">Service Door Assembly</td>
</tr>
<tr id="stair-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">OST009CM</td>
<td class="p-2.5">Roof Ladder 1</td>
</tr>
<tr id="stair-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">OBB004CM</td>
<td class="p-2.5">Lock Unit & door handle</td>
</tr>
<tr id="stair-row-5" class="transition duration-300">
<td class="p-2.5 text-center font-bold">5</td>
<td class="p-2.5 font-mono">OST010CM</td>
<td class="p-2.5">Roof Ladder 2</td>
</tr>
<tr id="stair-row-6" class="transition duration-300">
<td class="p-2.5 text-center font-bold">6</td>
<td class="p-2.5 font-mono">OST001CM</td>
<td class="p-2.5">Castor Wheel</td>
</tr>
<tr id="stair-row-7" class="transition duration-300">
<td class="p-2.5 text-center font-bold">7</td>
<td class="p-2.5 font-mono">OST007CM</td>
<td class="p-2.5">Hand Rail 2</td>
</tr>
<tr id="stair-row-8" class="transition duration-300">
<td class="p-2.5 text-center font-bold">8</td>
<td class="p-2.5 font-mono">OST011CM</td>
<td class="p-2.5">Hand Rail 3</td>
</tr>
<tr id="stair-row-9" class="transition duration-300">
<td class="p-2.5 text-center font-bold">9</td>
<td class="p-2.5 font-mono">OST005CM</td>
<td class="p-2.5">Hand Rail 1</td>
</tr>
<tr id="stair-row-10" class="transition duration-300">
<td class="p-2.5 text-center font-bold">10</td>
<td class="p-2.5 font-mono">OST006CM</td>
<td class="p-2.5">Step Plate</td>
</tr>
</tbody>
</table>
</div>',
            '5.1.7 Cabin Rotation' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.7. Cabin Rotation</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
Cabin Rotation.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1824/2328] max-w-sm select-none">
<img src="/images/modules/5.1.7.Cabin_Rotation.png" class="w-full h-full object-cover rounded-lg" alt="Cabin Rotation Technical Drawing">
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 16.67%; top: 31.62%;" onclick="scrollToRotationRow(1)" title="1. Rotation Drive System">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 66.45%; top: 55.41%;" onclick="scrollToRotationRow(2)" title="2. Bracket Mounting Motor">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 80.37%; top: 84.62%;" onclick="scrollToRotationRow(3)" title="3. Drive Unit Cabin Rotation">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 89.47%; top: 19.16%;" onclick="scrollToRotationRow(4)" title="4. Safety Door Shoe">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="rotation-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">OCB106AM</td>
<td class="p-2.5">Rotation Drive System</td>
</tr>
<tr id="rotation-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">OCB062SM</td>
<td class="p-2.5">Motor Mounting Bracket</td>
</tr>
<tr id="rotation-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">OCB105SM</td>
<td class="p-2.5">Drive Unit Cabin Rotation</td>
</tr>
<tr id="rotation-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">OCB103SM</td>
<td class="p-2.5">Safety Door Shoe</td>
</tr>
</tbody>
</table>
</div>
<p class="text-[10px] text-slate-400 mt-1 italic">Note: * Please see part code in the list of electrical components.</p>',
            '5.1.8 Cabin Curtain Assembly' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.8. Cabin Curtain Assembly</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
the Cabin Curtain Assembly.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1536/2304] max-w-sm select-none">
<img src="/images/modules/5.1.8.Cabin_Curtain_Assembly.png" class="w-full h-full object-cover rounded-lg" alt="Cabin Curtain Assembly Technical Drawing">
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 70.44%; top: 75.00%;" onclick="scrollToCurtainRow(1)" title="1. Roller I Cabin Rotation Ass\'y">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 55.60%; top: 97.31%;" onclick="scrollToCurtainRow(2)" title="2. Roller Cabin Lateral">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 82.55%; top: 73.44%;" onclick="scrollToCurtainRow(3)" title="3. Roller Cabin">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 69.92%; top: 9.46%;" onclick="scrollToCurtainRow(4)" title="4. Slat Curtain (with Glass)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 18.88%; top: 57.73%;" onclick="scrollToCurtainRow(5)" title="5. Slat Curtain (without glass)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 55.21%; top: 78.12%;" onclick="scrollToCurtainRow(6)" title="6. Bearing Housing">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 32.16%; top: 56.94%;" onclick="scrollToCurtainRow(7)" title="7. Barrel Curtain">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 91.28%; top: 16.15%;" onclick="scrollToCurtainRow(8)" title="8. Cover Side Curtain R/L (Top)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 91.28%; top: 58.77%;" onclick="scrollToCurtainRow(8)" title="8. Cover Side Curtain R/L (Bottom)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 35.29%; top: 2.26%;" onclick="scrollToCurtainRow(9)" title="9. Worm Gear Assembly (Top)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 64.84%; top: 66.93%;" onclick="scrollToCurtainRow(9)" title="9. Worm Gear Assembly (Bottom)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.68%; top: 2.26%;" onclick="scrollToCurtainRow(10)" title="10. Roller (Top)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.42%; top: 70.40%;" onclick="scrollToCurtainRow(10)" title="10. Roller (Bottom)">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 33.20%; top: 67.10%;" onclick="scrollToCurtainRow(11)" title="11. Plate Curtain Cabin">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="curtain-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">OCB006AM</td>
<td class="p-2.5">Roller I Cabin Rotation Ass\'y</td>
</tr>
<tr id="curtain-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">OCB007AM</td>
<td class="p-2.5">Roller Cabin Lateral</td>
</tr>
<tr id="curtain-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">OCB008AM</td>
<td class="p-2.5">Roller Cabin</td>
</tr>
<tr id="curtain-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">OCB085AM</td>
<td class="p-2.5">Slat Curtain (with Glass)</td>
</tr>
<tr id="curtain-row-5" class="transition duration-300">
<td class="p-2.5 text-center font-bold">5</td>
<td class="p-2.5 font-mono">OCB055CM</td>
<td class="p-2.5">Slat Curtain (without glass)</td>
</tr>
<tr id="curtain-row-6" class="transition duration-300">
<td class="p-2.5 text-center font-bold">6</td>
<td class="p-2.5 font-mono">OCB096SM</td>
<td class="p-2.5">Bearing Housing</td>
</tr>
<tr id="curtain-row-7" class="transition duration-300">
<td class="p-2.5 text-center font-bold">7</td>
<td class="p-2.5 font-mono">OCB012AM</td>
<td class="p-2.5">Barrel Curtain</td>
</tr>
<tr id="curtain-row-8" class="transition duration-300">
<td class="p-2.5 text-center font-bold">8</td>
<td class="p-2.5 font-mono">OCB021CM</td>
<td class="p-2.5">Cover Side Curtain R/L</td>
</tr>
<tr id="curtain-row-9" class="transition duration-300">
<td class="p-2.5 text-center font-bold">9</td>
<td class="p-2.5 font-mono">OCB020AM</td>
<td class="p-2.5">Worm Gear Assembly</td>
</tr>
<tr id="curtain-row-10" class="transition duration-300">
<td class="p-2.5 text-center font-bold">10</td>
<td class="p-2.5 font-mono">OCB019AM</td>
<td class="p-2.5">Roller</td>
</tr>
<tr id="curtain-row-11" class="transition duration-300">
<td class="p-2.5 text-center font-bold">11</td>
<td class="p-2.5 font-mono">OCB017CM</td>
<td class="p-2.5">Plate Curtain Cabin</td>
</tr>
</tbody>
</table>
</div>',
            '5.1.9 Auto Leveler Assembly' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.9. Auto Leveler Assembly</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
the Auto Leveler Assembly.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[2318/1824] max-w-md select-none">
<img src="/images/modules/5.1.9.Auto_Leverel_Assembly.png" class="w-full h-full object-cover rounded-lg" alt="Auto Leveler Assembly Technical Drawing">
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 67.30%; top: 76.64%;" onclick="scrollToLevelerRow(1)" title="1. Autolevel Assembly">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 47.71%; top: 24.89%;" onclick="scrollToLevelerRow(2)" title="2. Actuator Motor 4\"">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="leveler-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">OCB045AM</td>
<td class="p-2.5">Autolevel Assembly</td>
</tr>
<tr id="leveler-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">*</td>
<td class="p-2.5">4" Motor Actuator</td>
</tr>
</tbody>
</table>
</div>
<p class="text-[10px] text-slate-400 mt-1 italic">Note: * Please see part code in the list of electrical components.</p>',
            '5.1.10 Aircraft/Canopy Closure' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.10. Aircraft/Canopy Closure</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
the Aircraft/Canopy Closure.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1632/2176] max-w-xs select-none">
<img src="/images/modules/5.1.10.Aircraft_Closure.png" class="w-full h-full object-cover rounded-lg" alt="Aircraft/Canopy Closure Technical Drawing">
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 4.04%; top: 31.25%;" onclick="scrollToClosureRow(1)" title="1. Pad Closure">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 9.93%; top: 3.49%;" onclick="scrollToClosureRow(2)" title="2. Aircraft Closure Ass\'y">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 86.89%; top: 29.50%;" onclick="scrollToClosureRow(3)" title="3. Canopy Actuator">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 37.38%; top: 31.53%;" onclick="scrollToClosureRow(4)" title="4. Cover Aircraft Closure Right">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 41.30%; top: 31.53%;" onclick="scrollToClosureRow(5)" title="5. Cover Aircraft closure Left">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 56.99%; top: 97.52%;" onclick="scrollToClosureRow(6)" title="6. Closure Arm Ass\'y Right">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.78%; top: 97.52%;" onclick="scrollToClosureRow(7)" title="7. Closure Arm Ass\'y Left">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="closure-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">OCB107AM</td>
<td class="p-2.5">Pad Closure</td>
</tr>
<tr id="closure-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">OCB037CM</td>
<td class="p-2.5">Aircraft Closure Ass\'y</td>
</tr>
<tr id="closure-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">OCB108AM</td>
<td class="p-2.5">Canopy Actuator</td>
</tr>
<tr id="closure-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">OCB053CM</td>
<td class="p-2.5">Cover Aircraft Closure Right</td>
</tr>
<tr id="closure-row-5" class="transition duration-300">
<td class="p-2.5 text-center font-bold">5</td>
<td class="p-2.5 font-mono">OCB040CM</td>
<td class="p-2.5">Cover Aircraft closure Left</td>
</tr>
<tr id="closure-row-6" class="transition duration-300">
<td class="p-2.5 text-center font-bold">6</td>
<td class="p-2.5 font-mono">OCB041CM</td>
<td class="p-2.5">Closure Arm Ass\'y Right</td>
</tr>
<tr id="closure-row-7" class="transition duration-300">
<td class="p-2.5 text-center font-bold">7</td>
<td class="p-2.5 font-mono">OCB078CM</td>
<td class="p-2.5">Closure Arm Ass\'y Left</td>
</tr>
</tbody>
</table>
</div>
<p class="text-[10px] text-slate-400 mt-1 italic">Note: * Please see part code in the list of electrical components.</p>',
            '5.1.11 Swing Door and Window Assembly' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.11. Swing Door and Window Assembly</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
the Swing Door and Window Assembly.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1632/2176] max-w-xs select-none">
<img src="/images/modules/5.1.11.Swing_door.png" class="w-full h-full object-cover rounded-lg" alt="Swing Door and Window Assembly Technical Drawing">
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 79.29%; top: 5.70%;" onclick="scrollToSwingRow(1)" title="1. Left Side Shield Glass">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.60%; top: 25.87%;" onclick="scrollToSwingRow(2)" title="2. Front Shield Glass">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 59.38%; top: 50.74%;" onclick="scrollToSwingRow(3)" title="3. Bumper">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 36.50%; top: 32.70%;" onclick="scrollToSwingRow(4)" title="4. Right Side Glass">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 7.29%; top: 62.36%;" onclick="scrollToSwingRow(5)" title="5. Door Leaf Assy">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 7.29%; top: 57.86%;" onclick="scrollToSwingRow(6)" title="6. Lock System">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 84.07%; top: 31.53%;" onclick="scrollToSwingRow(7)" title="7. Safety Rope">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 36.34%; top: 75.60%;" onclick="scrollToSwingRow(8)" title="8. Door Handle">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="swing-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">OCB032SM</td>
<td class="p-2.5">Left Side Shield Glass</td>
</tr>
<tr id="swing-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">OCB029SM</td>
<td class="p-2.5">Front Shield Glass</td>
</tr>
<tr id="swing-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">OCB028CM</td>
<td class="p-2.5">Bumper</td>
</tr>
<tr id="swing-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">OCB034SM</td>
<td class="p-2.5">Right Side Glass</td>
</tr>
<tr id="swing-row-5" class="transition duration-300">
<td class="p-2.5 text-center font-bold">5</td>
<td class="p-2.5 font-mono">OCB036SM</td>
<td class="p-2.5">Door Leaf Assy</td>
</tr>
<tr id="swing-row-6" class="transition duration-300">
<td class="p-2.5 text-center font-bold">6</td>
<td class="p-2.5 font-mono">OCB042CM</td>
<td class="p-2.5">Lock System</td>
</tr>
<tr id="swing-row-7" class="transition duration-300">
<td class="p-2.5 text-center font-bold">7</td>
<td class="p-2.5 font-mono">OCB101SM</td>
<td class="p-2.5">Safety Rope</td>
</tr>
<tr id="swing-row-8" class="transition duration-300">
<td class="p-2.5 text-center font-bold">8</td>
<td class="p-2.5 font-mono">OCB109AM</td>
<td class="p-2.5">Door Handle</td>
</tr>
</tbody>
</table>
</div>
<p class="text-[10px] text-slate-400 mt-1 italic">Note: * Please see part code in the list of electrical components.</p>',
            '5.1.12 Rubber Weathering' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.12. Rubber Weathering</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
Rubber Weathering.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1632/2176] max-w-xs select-none">
<img src="/images/modules/5.1.12.Rubber_Weathering.png" class="w-full h-full object-cover rounded-lg" alt="Rubber Weathering Technical Drawing">
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 14.52%; top: 75.60%;" onclick="scrollToWeatheringRow(1)" title="1. Rigid Frame Weathering">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 8.27%; top: 88.28%;" onclick="scrollToWeatheringRow(2)" title="2. Weathering Corner Upper">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 31.74%; top: 95.82%;" onclick="scrollToWeatheringRow(3)" title="3. Rigid Frame Weathering">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.64%; top: 95.36%;" onclick="scrollToWeatheringRow(4)" title="4. Weathering Corner Lower">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 49.69%; top: 68.70%;" onclick="scrollToWeatheringRow(5)" title="5. Rigid Frame Weathering">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 8.21%; top: 71.92%;" onclick="scrollToWeatheringRow(6)" title="6. Weathering Corner Upper">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 23.04%; top: 56.11%;" onclick="scrollToWeatheringRow(7)" title="7. Rubber Black">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 70.04%; top: 92.23%;" onclick="scrollToWeatheringRow(8)" title="8. Upper Rotunda Weathering">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 48.10%; top: 24.13%;" onclick="scrollToWeatheringRow(9)" title="9. Inside Weathering">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 77.63%; top: 71.28%;" onclick="scrollToWeatheringRow(9)" title="9. Inside Weathering">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 90.99%; top: 52.25%;" onclick="scrollToWeatheringRow(10)" title="10. Inside Weathering">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 77.88%; top: 23.67%;" onclick="scrollToWeatheringRow(11)" title="11. Upper Bubble Weathering">
</button>
<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 46.08%; top: 16.68%;" onclick="scrollToWeatheringRow(12)" title="12. Inside Weathering">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="weathering-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">OAT014CM</td>
<td class="p-2.5">Rigid Frame Weathering</td>
</tr>
<tr id="weathering-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">OAT012CM</td>
<td class="p-2.5">Weathering Corner Upper</td>
</tr>
<tr id="weathering-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">OAT013CM</td>
<td class="p-2.5">Rigid Frame Weathering</td>
</tr>
<tr id="weathering-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">OAT015CM</td>
<td class="p-2.5">Weathering Corner Lower</td>
</tr>
<tr id="weathering-row-5" class="transition duration-300">
<td class="p-2.5 text-center font-bold">5</td>
<td class="p-2.5 font-mono">OAT016CM</td>
<td class="p-2.5">Rigid Frame Weathering</td>
</tr>
<tr id="weathering-row-6" class="transition duration-300">
<td class="p-2.5 text-center font-bold">6</td>
<td class="p-2.5 font-mono">OBT001CM</td>
<td class="p-2.5">Weathering Corner Upper</td>
</tr>
<tr id="weathering-row-7" class="transition duration-300">
<td class="p-2.5 text-center font-bold">7</td>
<td class="p-2.5 font-mono">OBT003CM</td>
<td class="p-2.5">Rubber Black</td>
</tr>
<tr id="weathering-row-8" class="transition duration-300">
<td class="p-2.5 text-center font-bold">8</td>
<td class="p-2.5 font-mono">ORT019CM</td>
<td class="p-2.5">Upper Rotunda Weathering</td>
</tr>
<tr id="weathering-row-9" class="transition duration-300">
<td class="p-2.5 text-center font-bold">9</td>
<td class="p-2.5 font-mono">OBT005CM</td>
<td class="p-2.5">Inside Weathering</td>
</tr>
<tr id="weathering-row-10" class="transition duration-300">
<td class="p-2.5 text-center font-bold">10</td>
<td class="p-2.5 font-mono">OAT017CM</td>
<td class="p-2.5">Inside Weathering</td>
</tr>
<tr id="weathering-row-11" class="transition duration-300">
<td class="p-2.5 text-center font-bold">11</td>
<td class="p-2.5 font-mono">OBB005SM</td>
<td class="p-2.5">Upper Bubble Weathering</td>
</tr>
<tr id="weathering-row-12" class="transition duration-300">
<td class="p-2.5 text-center font-bold">12</td>
<td class="p-2.5 font-mono">OBT004CM</td>
<td class="p-2.5">Inside Weathering</td>
</tr>
</tbody>
</table>
</div>
<p class="text-[10px] text-slate-400 mt-1 italic">Note: * Please see part code in the list of electrical components.</p>
<p class="text-[10px] text-red-500 font-semibold mt-1">NOTE: Please include the type of bridge and tunnel for each weathering order</p>',
            '5.1.13 Wire Rope Equalizer' => '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.13. Wire Rope Equalizer</h4>
<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a working drawing (technical drawing) along with a list of components that make up
the Wire Rope Equalizer.<strong>Click on the blue part number button in the image</strong> to automatically highlight and scroll to the appropriate part number row in the table below.</p>
<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[2176/1632] w-full select-none" style="max-width: 440px;">
<img src="/images/modules/5.1.13.Wire_Rope_Equalizer.png" class="w-full h-full object-cover rounded-lg" alt="Wire Rope Equalizer Technical Drawing">
<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 91.00%; top: 39.00%;" onclick="scrollToEqualizerRow(1)" title="1. Wire Rope 1">
</button>
<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 38.30%; top: 5.00%;" onclick="scrollToEqualizerRow(1)" title="1. Wire Rope 1">
</button>
<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 93.90%; top: 39.00%;" onclick="scrollToEqualizerRow(2)" title="2. Wire Rope 2">
</button>
<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 65.90%; top: 33.80%;" onclick="scrollToEqualizerRow(2)" title="2. Wire Rope 2">
</button>
<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 3.70%; top: 80.50%;" onclick="scrollToEqualizerRow(3)" title="3. Drum Tension Ass\'y">
</button>
<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 44.00%; top: 44.00%;" onclick="scrollToEqualizerRow(4)" title="4. Cable Sheave Ass\'y">
</button>
<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 35.10%; top: 63.10%;" onclick="scrollToEqualizerRow(5)" title="5. Cable Equalizer ass\'y, Detail B">
</button>
<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 61.80%; top: 38.20%;" onclick="scrollToEqualizerRow(6)" title="6. Wire Rope Anchorage">
</button>
</div>
<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">
<table class="min-w-full divide-y divide-slate-200 text-xs">
<thead>
<tr class="bg-slate-50 text-slate-700 font-bold">
<th class="p-2.5 text-center w-16">No.</th>
<th class="p-2.5 text-left w-36">Part No.</th>
<th class="p-2.5 text-left">Part Name</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">
<tr id="equalizer-row-1" class="transition duration-300">
<td class="p-2.5 text-center font-bold">1</td>
<td class="p-2.5 font-mono">2BT013SM</td>
<td class="p-2.5">Wire Rope 1</td>
</tr>
<tr id="equalizer-row-2" class="transition duration-300">
<td class="p-2.5 text-center font-bold">2</td>
<td class="p-2.5 font-mono">2BT017SM</td>
<td class="p-2.5">Wire Rope 2</td>
</tr>
<tr id="equalizer-row-3" class="transition duration-300">
<td class="p-2.5 text-center font-bold">3</td>
<td class="p-2.5 font-mono">2BT001AM</td>
<td class="p-2.5">Drum Tension Ass\'y</td>
</tr>
<tr id="equalizer-row-4" class="transition duration-300">
<td class="p-2.5 text-center font-bold">4</td>
<td class="p-2.5 font-mono">2BT006AM</td>
<td class="p-2.5">Cable Sheave Ass\'y</td>
</tr>
<tr id="equalizer-row-5" class="transition duration-300">
<td class="p-2.5 text-center font-bold">5</td>
<td class="p-2.5 font-mono">2BT009AM</td>
<td class="p-2.5">Cable Equalizer ass\'y, Detail B</td>
</tr>
<tr id="equalizer-row-6" class="transition duration-300">
<td class="p-2.5 text-center font-bold">6</td>
<td class="p-2.5 font-mono">2BT103AM</td>
<td class="p-2.5">Wire Rope Anchorage</td>
</tr>
<tr id="equalizer-row-7" class="transition duration-300">
<td class="p-2.5 text-center font-bold">7</td>
<td class="p-2.5 font-mono">2BT016AM</td>
<td class="p-2.5">Cable Equalizer Ass\'y, Detail C</td>
</tr>
</tbody>
</table>
</div>
<p class="text-[10px] text-slate-400 mt-1 italic">Note: * Please see part code in the list of electrical components.</p>',
            '5.2 Electrical Parts and Others' => '<div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 max-w-xl mt-4 space-y-6">
<div class="flex items-start gap-4">
<div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
</svg>
</div>
<div class="space-y-2">
<h4 class="text-sm font-bold text-slate-800">Electrical Parts</h4>
<p class="text-xs text-slate-600 leading-relaxed"> For electrical parts, please go to <a href="/courses/1/chapters/7" class="text-blue-600 hover:text-blue-800 font-bold underline transition inline-flex items-center gap-1"> attachment 7 <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
</svg>
</a>.</p>
</div>
</div>
</div>',
            '5.3 Special Tools' => '<p class="text-xs text-slate-600 leading-relaxed mb-4">The following is a list of special equipment (Special Tools) used for maintenance and arrangement of
Garbarata components.<em class="text-blue-600 font-semibold">Click on each tool name below</em> to view images and visual details.</p>
<div class="space-y-3 mt-6" id="special-tools-accordion">
<details id="tool-1" class="group rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden" open>
<summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white transition-colors duration-200 list-none">
<div class="flex items-center gap-3">
<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm">1</span>
<span class="font-semibold text-slate-800 text-sm">5.3.1. Jacking stand</span>
</div>
<svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
</svg>
</summary>
<div class="border-t border-slate-100 bg-slate-50/50 p-5">
<p class="text-xs text-slate-500 mb-4">Special jack supports used to support the Garbarata structure when carrying out maintenance on the
wheels or elevation system.</p>
<div class="rounded-xl border border-slate-200 bg-white p-3 shadow-xs max-w-xl mx-auto">
<img src="/images/modules/5.3.SpecialTools/5.3.1.Jacking_Stand.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="5.3.1. Jacking stand" loading="lazy">
</div>
</div>
</details>
<details id="tool-2" class="group rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
<summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white transition-colors duration-200 list-none">
<div class="flex items-center gap-3">
<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm">2</span>
<span class="font-semibold text-slate-800 text-sm">5.3.2. Wrench for roller tunnel adjustment</span>
</div>
<svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
</svg>
</summary>
<div class="border-t border-slate-100 bg-slate-50/50 p-5">
<p class="text-xs text-slate-500 mb-4">Special wrench to adjust the position of the roller in the tunnel section so that the sliding
movement is smooth and straight.</p>
<div class="rounded-xl border border-slate-200 bg-white p-3 shadow-xs max-w-xl mx-auto">
<img src="/images/modules/5.3.SpecialTools/5.3.2.Wrench_For_Roller.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="5.3.2. Wrench for roller tunnel adjustment" loading="lazy">
</div>
</div>
</details>
<details id="tool-3" class="group rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
<summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white transition-colors duration-200 list-none">
<div class="flex items-center gap-3">
<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm">3</span>
<span class="font-semibold text-slate-800 text-sm">5.3.3. Tuner roller driver</span>
</div>
<svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
</svg>
</summary>
<div class="border-t border-slate-100 bg-slate-50/50 p-5">
<p class="text-xs text-slate-500 mb-4">Pushers/controllers for installation or dismantling of tunnel rollers.</p>
<div class="rounded-xl border border-slate-200 bg-white p-3 shadow-xs max-w-xl mx-auto">
<img src="/images/modules/5.3.SpecialTools/5.3.3.Tunnel_Roller_Driver.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="5.3.3. Tunner roller driver" loading="lazy">
</div>
</div>
</details>
<details id="tool-4" class="group rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
<summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white transition-colors duration-200 list-none">
<div class="flex items-center gap-3">
<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm">4</span>
<span class="font-semibold text-slate-800 text-sm">5.3.4. Socket for curtain tension</span>
</div>
<svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
</svg>
</summary>
<div class="border-t border-slate-100 bg-slate-50/50 p-5">
<p class="text-xs text-slate-500 mb-4">Special socket wrench for rotating and adjusting spring tension on cabin/rotunda blinds.</p>
<div class="rounded-xl border border-slate-200 bg-white p-3 shadow-xs max-w-xl mx-auto">
<img src="/images/modules/5.3.SpecialTools/5.3.4.Socket_For_Curtain_Tension.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="5.3.4. Socket for curtain tension" loading="lazy">
</div>
</div>
</details>
<details id="tool-5" class="group rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
<summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white transition-colors duration-200 list-none">
<div class="flex items-center gap-3">
<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm">5</span>
<span class="font-semibold text-slate-800 text-sm">5.3.5. Towing bar</span>
</div>
<svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
</svg>
</summary>
<div class="border-t border-slate-100 bg-slate-50/50 p-5">
<p class="text-xs text-slate-500 mb-4">Emergency tow bar to move the position of the bridge in the event of a main propulsion system
failure.</p>
<div class="rounded-xl border border-slate-200 bg-white p-3 shadow-xs max-w-xl mx-auto">
<img src="/images/modules/5.3.SpecialTools/5.3.5.Towing_bar.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="5.3.5. Towing bar" loading="lazy">
</div>
</div>
</details>
<details id="tool-6" class="group rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
<summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white transition-colors duration-200 list-none">
<div class="flex items-center gap-3">
<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm">6</span>
<span class="font-semibold text-slate-800 text-sm">5.3.6. Wrench for wheel boogie tire</span>
</div>
<svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
</svg>
</summary>
<div class="border-t border-slate-100 bg-slate-50/50 p-5">
<p class="text-xs text-slate-500 mb-4">Large wrench specifically designed for removing or tightening solid rubber tire bolts on the wheel
boogie.</p>
<div class="rounded-xl border border-slate-200 bg-white p-3 shadow-xs max-w-xl mx-auto">
<img src="/images/modules/5.3.SpecialTools/5.3.6.Wrench_For_Wheel.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="5.3.6. Wrench for wheel boogie tyre" loading="lazy">
</div>
</div>
</details>
<details id="tool-7" class="group rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
<summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white transition-colors duration-200 list-none">
<div class="flex items-center gap-3">
<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm">7</span>
<span class="font-semibold text-slate-800 text-sm">5.3.7. Driver for flange lift column bolt</span>
</div>
<svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
</svg>
</summary>
<div class="border-t border-slate-100 bg-slate-50/50 p-5">
<p class="text-xs text-slate-500 mb-4">Special puller/actuator key for flange bolts on the main lift column.</p>
<div class="rounded-xl border border-slate-200 bg-white p-3 shadow-xs max-w-xl mx-auto">
<img src="/images/modules/5.3.SpecialTools/5.3.7.Driver_For_Flange.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="5.3.7. Driver for flange lift column bolt" loading="lazy">
</div>
</div>
</details>
</div>
<script>document.addEventListener("DOMContentLoaded", function() { var allDetails = document.querySelectorAll("#special-tools-accordion details"); allDetails.forEach(function(det) { det.addEventListener("toggle", function() { if (det.open) { allDetails.forEach(function(other) { if (other !== det && other.open) { other.removeAttribute("open"); setTimeout(function() { det.scrollIntoView({ behavior: "smooth", block: "start" }); }, 100);',
            '6.1 Cyclo® 6000' => '<p class="text-xs text-slate-500 mb-3">Cyclo Drive 6000 series catalog document (reducer / gearbox). Contains specifications, ratios,
torque and dimensions of the drive unit used in the Garbarata system.</p>
<div class="rounded-lg overflow-hidden border border-slate-200 shadow-inner bg-white">
<iframe src="/pdfs/chapter6/katalog_Cyclo_6000.pdf" width="100%" height="700" class="block w-full" title="Cyclo® 6000" loading="lazy">
<p class="p-4 text-xs text-slate-500">Your browser does not support direct PDF viewing. <a href="/pdfs/chapter6/katalog_Cyclo_6000.pdf" class="text-blue-600 underline" target="_blank">Click here to open PDF</a>.</p>
</iframe>
</div>',
            '6.2 Warner Installation & Operation Manual' => '<p class="text-xs text-slate-500 mb-3">Installation documents and operating guides for Warner components used in the Garbarata control and
propulsion system.</p>
<div class="rounded-lg overflow-hidden border border-slate-200 shadow-inner bg-white">
<iframe src="/pdfs/chapter6/Warner_Katalog.pdf" width="100%" height="700" class="block w-full" title="Warner Installation & Operation Manual" loading="lazy">
<p class="p-4 text-xs text-slate-500">Your browser does not support direct PDF viewing. <a href="/pdfs/chapter6/Warner_Katalog.pdf" class="text-blue-600 underline" target="_blank">Click here to open PDF</a>.</p>
</iframe>
</div>',
            '6.3 HIWIN LAS Series' => '<p class="text-xs text-slate-500 mb-3">Hiwin\'s LAS series Linear Guideway catalog document. Contains specifications, dimensions and part
numbers of linear guide components used on Garbarata.</p>
<div class="rounded-lg overflow-hidden border border-slate-200 shadow-inner bg-white">
<iframe src="/pdfs/chapter6/Katalog_Hiwin_Las_Series.pdf" width="100%" height="700" class="block w-full" title="HIWIN LAS Series" loading="lazy">
<p class="p-4 text-xs text-slate-500">Your browser does not support direct PDF viewing. <a href="/pdfs/chapter6/Katalog_Hiwin_Las_Series.pdf" class="text-blue-600 underline" target="_blank">Click here to open PDF</a>.</p>
</iframe>
</div>',
            '6.4 Rooftop Packaged Air Conditioners' => '<p class="text-xs text-slate-500 mb-3">Catalogue document for Rooftop Packaged AC units used in the Garbarata cooling system. Contains
technical specifications, capacity and unit dimensions.</p>
<div class="rounded-lg overflow-hidden border border-slate-200 shadow-inner bg-white">
<iframe src="/pdfs/chapter6/Katalog_Rooftop _Packaged.pdf" width="100%" height="700" class="block w-full" title="Rooftop Packaged Air Conditioners" loading="lazy">
<p class="p-4 text-xs text-slate-500">Your browser does not support direct PDF viewing. <a href="/pdfs/chapter6/Katalog_Rooftop _Packaged.pdf" class="text-blue-600 underline" target="_blank">Click here to open PDF</a>.</p>
</iframe>
</div>',
            '7.1 Lembar Gambar 1' => '<p>Attachment to Electrical Drawing Sheet 1 (As-Built Garbarata Diagram).</p>',
            '7.2 Lembar Gambar 2' => '<p>Attachment to Electrical Drawing Sheet 2 (As-Built Garbarata Diagram).</p>',
            '7.3 Lembar Gambar 3' => '<p>Attachment to Electrical Drawing Sheet 3 (As-Built Garbarata Diagram).</p>',
            '7.4 Lembar Gambar 4' => '<p>Attachment to Electrical Drawing Sheet 4 (As-Built Garbarata Diagram).</p>',
            '7.5 Lembar Gambar 5' => '<p>Attachment to Electrical Drawing Sheet 5 (As-Built Garbarata Diagram).</p>',
            '7.6 Lembar Gambar 6' => '<p>Attachment to Electrical Drawing Sheet 6 (As-Built Garbarata Diagram).</p>',
            '7.7 Lembar Gambar 7' => '<p>Attachment to Electrical Drawing Sheet 7 (As-Built Garbarata Diagram).</p>',
            '7.8 Lembar Gambar 8' => '<p>Attachment to Electrical Drawing Sheet 8 (As-Built Garbarata Diagram).</p>',
            '7.9 Lembar Gambar 9' => '<p>Attachment to Electrical Drawing Sheet 9 (As-Built Garbarata Diagram).</p>',
            '7.10 Lembar Gambar 10' => '<p>Attachment to Electrical Drawing Sheet 10 (As-Built Garbarata Diagram).</p>',
            '7.11 Lembar Gambar 11' => '<p>Attachment to Electrical Drawing Sheet 11 (As-Built Garbarata Diagram).</p>',
            '7.12 Lembar Gambar 12' => '<p>Attachment to Electrical Drawing Sheet 12 (As-Built Garbarata Diagram).</p>',
            '7.13 Lembar Gambar 13' => '<p>Attachment to Electrical Drawing Sheet 13 (As-Built Garbarata Diagram).</p>',
            '7.14 Lembar Gambar 14' => '<p>Attachment to Electrical Drawing Sheet 14 (As-Built Garbarata Diagram).</p>',
        ];

        // --- Chapter Titles (EN) ---
        $chapterTitles = [
            'BAB 1: DESKRIPSI KOMPONEN' => 'CHAPTER 1: COMPONENT DESCRIPTION',
            'BAB 2: SPESIFIKASI' => 'CHAPTER 2: SPECIFICATIONS',
            'BAB 3: PENGOPERASIAN' => 'CHAPTER 3: OPERATION',
            'BAB 4: PERAWATAN' => 'CHAPTER 4: MAINTENANCE',
            'BAB 5: SUKU CADANG' => 'CHAPTER 5: SPARE PARTS',
            'BAB 6: DOKUMEN REFERENSI' => 'CHAPTER 6: REFERENCE DOCUMENTS',
            'BAB 7: LAMPIRAN GAMBAR' => 'CHAPTER 7: DRAWING ATTACHMENTS',
        ];

        $moduleTitleTranslations = [
            '1.1 Model' => '1.1 Model',
            '1.2 Batasan Rancangan' => '1.2 Design Limits',
            '1.3 Dimensi' => '1.3 Dimensions',
            '1.4 Performa' => '1.4 Performance',
            '2.1 Power Supply' => '2.1 Power Supply',
            '2.2 Aktuator' => '2.2 Actuators',
            '2.3 Pencahayaan ' => '2.3 Lighting',
            '2.4 Pencahayaan' => '2.4 Lighting',
            '4.1 Perawatan Garbarata' => '4.1 Garbarata Maintenance',
            '4.1.1 Karpet' => '4.1.1 Carpet',
            '4.1.2 Jendela' => '4.1.2 Windows',
            '4.1.3 Dinding dan Ceiling Panel' => '4.1.3 Walls and Ceiling Panels',
            '4.1.4 Panel Dinding Kaca' => '4.1.4 Glass Wall Panels',
            '4.1.5 Peralatan Penerangan' => '4.1.5 Lighting Equipment',
            '4.1.6 Inspeksi Permukaan Luar' => '4.1.6 Exterior Surface Inspection',
            '4.2 Rotunda dan Tekanan Cabin Curtain' => '4.2 Rotunda and Cabin Curtain Pressure',
            '4.2.1 Penyetelan Tekanan Curtain' => '4.2.1 Curtain Pressure Adjustment',
            '4.3 Drive Column dan Wheel Boogie' => '4.3 Drive Column and Wheel Bogie',
            '4.3.1 Inspeksi Vertikal Limit Switch' => '4.3.1 Vertical Limit Switch Inspection',
            '4.3.2 Bantalan Lift Column' => '4.3.2 Lift Column Bearings',
            '4.3.3 Inspeksi Ball Screw' => '4.3.3 Ball Screw Inspection',
            '4.3.4 Kekencangan Lift Column' => '4.3.4 Lift Column Tightness',
            '4.3.5 Rantai Boogie Drive' => '4.3.5 Bogie Drive Chain',
            '4.3.6 Rem Cyclo Drive Motor' => '4.3.6 Cyclo Drive Motor Brake',
            '4.3.7 Ban' => '4.3.7 Tires',
            '4.4 Roller Tunnel' => '4.4 Tunnel Rollers',
            '4.4.1 Distribusi Bobot pada Roller' => '4.4.1 Weight Distribution on Rollers',
            '4.4.2 Pengaturan Vertikal Roller' => '4.4.2 Roller Vertical Adjustment',
            '4.4.3 Pengaturan Horizontal Roller' => '4.4.3 Roller Horizontal Adjustment',
            '4.5.1 Perbaikan Canopy Fabric' => '4.5.1 Canopy Fabric Repair',
            '4.6.1 Pemeriksaan Harian untuk Operator' => '4.6.1 Daily Inspection for Operators',
            '4.6.2 Pelumasan' => '4.6.2 Lubrication',
            '4.6.3.2 LIMIT SWITCH DAN OPERASI DETEKTOR' => '4.6.3.2 LIMIT SWITCH AND DETECTOR OPERATION',
            '4.6.3.3 PERIKSA BAN' => '4.6.3.3 CHECK TIRES',
            '4.6.3.4 DETAIL KESELURUHAN' => '4.6.3.4 OVERALL DETAILS',
            '4.6.4.2 KABIN' => '4.6.4.2 CABIN',
            '4.6.4.3 SAMBUNGAN LISTRIK' => '4.6.4.3 ELECTRICAL CONNECTIONS',
            '4.6.4.5 PEMERIKSAAN BAN-BAN' => '4.6.4.5 TIRE INSPECTION',
            '4.6.4.6 KONDISI UMUM DARI EXTERIOR DAN PELAPIS CUACA' => '4.6.4.6 GENERAL CONDITION OF EXTERIOR AND WEATHER SEALS',
            '4.6.4.7 ROTUNDA (LUMAS!)' => '4.6.4.7 ROTUNDA (LUBRICATE!)',
            '4.6.4.8 TUNNELS' => '4.6.4.8 TUNNELS',
            '4.6.4.9 VERTICAL COLUMN' => '4.6.4.9 VERTICAL COLUMN',
            '4.6.4.10 WHEEL BOOGIE' => '4.6.4.10 WHEEL BOGIE',
            '4.6.4.11 KABIN (LUMAS!)' => '4.6.4.11 CABIN (LUBRICATE!)',
            '4.7 Panduan Troubleshooting' => '4.7 Troubleshooting Guide',
        ];

        // Update Chapter EN titles
        foreach (Chapter::all() as $chapter) {
            $titleId = $chapter->getTranslation('title', 'id');
            $enTitle = $chapterTitles[$titleId] ?? $titleId;

            if (empty($chapter->getTranslation('title', 'en')) || $chapter->getTranslation('title', 'en') === $titleId) {
                $chapter->setTranslation('title', 'en', $enTitle);
                $chapter->save();
            }
        }

        // Update Module EN titles and content
        foreach (Module::all() as $module) {
            $titleId = $module->getTranslation('title', 'id') ?? '';
            $contentId = $module->getTranslation('content', 'id') ?? '';

            // Title: use override or fall back to the same as ID
            // (module titles like "1.1 Rotunda" are already English/universal)
            $enTitle = $moduleTitleTranslations[$titleId] ?? $titleId;
            if (preg_match('/^(7\.(\d+)) Lembar Gambar \d+$/', $titleId, $matches)) {
                $enTitle = $matches[1] . ' Drawing Sheet ' . $matches[2];
            }

            if (empty($module->getTranslation('title', 'en')) || $module->getTranslation('title', 'en') === $titleId) {
                $module->setTranslation('title', 'en', $enTitle);
            }

            // Content: use real translation override if available, otherwise copy ID content
            $enContent = $englishContent[$titleId] ?? $contentId;
            if (empty($module->getTranslation('content', 'en'))) {
                $module->setTranslation('content', 'en', $enContent);
            }

            $module->save();
        }

        $this->command->info('English content seeded successfully for all Chapters and Modules!');
    }
}
